<?php
declare(strict_types=1);

require dirname(__DIR__) . '/includes/functions.php';

header('Cache-Control: no-store');
header('X-Content-Type-Options: nosniff');

function admin_json(int $status, array $payload): void
{
    http_response_code($status);
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

function csv_safe(string $value): string
{
    if (preg_match('/^[=+\-@]/', $value) === 1) {
        return "'" . $value;
    }
    return $value;
}

$user = current_user();
if ($user === null) {
    admin_json(401, ['ok' => false, 'error' => 'No autorizado.']);
}

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

if ($method === 'GET' && (($_GET['export'] ?? '') === 'csv')) {
    if (($user['role'] ?? '') !== 'admin') {
        admin_json(403, ['ok' => false, 'error' => 'Solo administración exporta el CSV.']);
    }
    $leads = fetch_leads($user, [
        'comuna' => $_GET['comuna'] ?? '',
        'score' => $_GET['score'] ?? '',
        'estado' => $_GET['estado'] ?? '',
        'q' => $_GET['q'] ?? '',
    ]);
    header('Content-Type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename="leads-panel-solar-norte.csv"');
    echo "\xEF\xBB\xBF";
    $out = fopen('php://output', 'wb');
    if ($out === false) {
        exit;
    }
    $headers = ['id', 'fecha', 'comuna', 'tipo_proyecto', 'gasto_luz', 'plazo', 'nombre', 'whatsapp', 'email', 'lead_score', 'estado', 'notas', 'source_url', 'utm_source', 'utm_medium', 'utm_campaign', 'kwp_estimado', 'ahorro_estimado', 'origen_cta', 'pagina_tipo'];
    fputcsv($out, $headers, ';');
    foreach ($leads as $lead) {
        $line = [];
        foreach ($headers as $column) {
            $key = $column === 'fecha' ? 'created_at' : $column;
            $line[] = csv_safe((string) ($lead[$key] ?? ''));
        }
        fputcsv($out, $line, ';');
    }
    fclose($out);
    exit;
}

if ($method === 'GET') {
    $filters = [
        'comuna' => $_GET['comuna'] ?? '',
        'score' => $_GET['score'] ?? '',
        'estado' => $_GET['estado'] ?? '',
        'q' => $_GET['q'] ?? '',
    ];
    admin_json(200, [
        'ok' => true,
        'role' => $user['role'],
        'kpis' => lead_kpis(zona_nombres($user)),
        'leads' => fetch_leads($user, $filters),
    ]);
}

if ($method === 'POST' || $method === 'PATCH') {
    $data = input_data();
    if (!csrf_ok(field($data, 'csrf'))) {
        admin_json(403, ['ok' => false, 'error' => 'La sesión expiró. Recarga el panel.']);
    }
    $id = (int) field($data, 'id');
    $estado = field($data, 'estado');
    $notas = field($data, 'notas');
    if (!update_lead($user, $id, $estado, $notas)) {
        admin_json(422, ['ok' => false, 'error' => 'No se pudo actualizar ese lead.']);
    }
    admin_json(200, [
        'ok' => true,
        'kpis' => lead_kpis(zona_nombres($user)),
    ]);
}

header('Allow: GET, POST, PATCH');
admin_json(405, ['ok' => false, 'error' => 'Método no permitido.']);

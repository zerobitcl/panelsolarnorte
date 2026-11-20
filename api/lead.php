<?php
declare(strict_types=1);

require dirname(__DIR__) . '/includes/functions.php';

header('Content-Type: application/json; charset=UTF-8');
header('Cache-Control: no-store');
header('X-Content-Type-Options: nosniff');

function lead_json(int $status, array $payload): void
{
    http_response_code($status);
    echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    header('Allow: POST');
    lead_json(405, ['ok' => false, 'error' => 'Método no permitido.']);
}

$length = (int) ($_SERVER['CONTENT_LENGTH'] ?? 0);
if ($length > 20000) {
    lead_json(413, ['ok' => false, 'error' => 'El envío es demasiado grande.']);
}

$data = input_data();
$catalog = lead_catalog();

// Beacon de clic a WhatsApp: tabla separada, no contamina leads ni rate-limit.
if (field($data, 'tipo') === 'click') {
    $origen = clean_line(field($data, 'origen_cta'), 40) ?: 'whatsapp_directo';
    $source = clean_line(field($data, 'source_url'), 500);
    if ($source !== '' && preg_match('#^https?://#i', $source) !== 1) {
        $source = '';
    }
    $comunaCode = field($data, 'comuna');
    $comunaName = $catalog['comunas'][$comunaCode] ?? 'Sin comuna';
    $tenant = tenant_for_comuna($comunaCode !== '' ? $comunaCode : null);
    try {
        $pdo = db();
        $insert = $pdo->prepare(
            'INSERT INTO wa_clicks (
                created_at, comuna, origen_cta, source_url, pagina_tipo, plaza_id, ip_hash
            ) VALUES (
                :created_at, :comuna, :origen_cta, :source_url, :pagina_tipo, :plaza_id, :ip_hash
            )'
        );
        $insert->execute([
            'created_at' => (new DateTimeImmutable('now'))->format(DateTimeInterface::ATOM),
            'comuna' => $comunaName,
            'origen_cta' => $origen,
            'source_url' => $source,
            'pagina_tipo' => clean_line(field($data, 'pagina_tipo'), 40) ?: 'web',
            'plaza_id' => $tenant['plaza_id'],
            'ip_hash' => ip_hash(),
        ]);
    } catch (Throwable $e) {
        error_log('Panel Solar Norte click: ' . $e->getMessage());
    }
    lead_json(200, [
        'ok' => true,
        'whatsapp_destino' => $tenant['whatsapp'],
    ]);
}

if (field($data, 'psn_hp') !== '') {
    lead_json(200, ['ok' => true, 'resumen' => null]);
}

$ts = (int) field($data, 'form_ts');
$now = time();
if ($ts < $now - 86400 || $ts > $now + 300) {
    lead_json(422, ['ok' => false, 'error' => 'El formulario venció. Recarga la página y envíalo de nuevo.']);
}
if ($now - $ts < 3) {
    lead_json(200, ['ok' => true, 'resumen' => null]);
}

$comunaCode = field($data, 'comuna');
$tipoCode = field($data, 'tipo_proyecto');
$gastoCode = field($data, 'gasto_luz');
$plazoCode = field($data, 'plazo');

if (!isset($catalog['comunas'][$comunaCode])) {
    lead_json(422, ['ok' => false, 'error' => 'Elige la comuna del proyecto.']);
}
if (!isset($catalog['tipos'][$tipoCode])) {
    lead_json(422, ['ok' => false, 'error' => 'Elige el tipo de proyecto.']);
}
if (!isset($catalog['gastos'][$gastoCode])) {
    lead_json(422, ['ok' => false, 'error' => 'Indica el gasto mensual de electricidad.']);
}
if (!isset($catalog['plazos'][$plazoCode])) {
    lead_json(422, ['ok' => false, 'error' => 'Indica el plazo.']);
}

$nombre = clean_line(field($data, 'nombre'), 120);
if (preg_match("/^[\p{L}][\p{L}\s'.-]{2,119}$/u", $nombre) !== 1) {
    lead_json(422, ['ok' => false, 'error' => 'Escribe tu nombre completo.']);
}

$whatsapp = normalize_phone(field($data, 'whatsapp'));
if ($whatsapp === null) {
    lead_json(422, ['ok' => false, 'error' => 'El WhatsApp tiene que ser un móvil chileno, por ejemplo +56 9 1234 5678.']);
}

$emailRaw = clean_line(field($data, 'email'), 160);
$email = '';
if ($emailRaw !== '') {
    if (!valid_email($emailRaw)) {
        lead_json(422, ['ok' => false, 'error' => 'El email no tiene un formato válido. Puedes dejarlo vacío.']);
    }
    $email = $emailRaw;
}

$source = clean_line(field($data, 'source_url'), 500);
if ($source !== '' && preg_match('#^https?://#i', $source) !== 1) {
    $source = '';
}

$kwp = clean_line(field($data, 'kwp_estimado'), 20);
$ahorro = clean_line(field($data, 'ahorro_estimado'), 40);
$origen = clean_line(field($data, 'origen_cta'), 40) ?: 'hero';
$paginaTipo = clean_line(field($data, 'pagina_tipo'), 40) ?: 'web';
$tenant = tenant_for_comuna($comunaCode);

$lead = [
    'created_at' => (new DateTimeImmutable('now'))->format(DateTimeInterface::ATOM),
    'comuna' => $catalog['comunas'][$comunaCode],
    'tipo_proyecto' => $catalog['tipos'][$tipoCode],
    'gasto_luz' => $catalog['gastos'][$gastoCode],
    'plazo' => $catalog['plazos'][$plazoCode],
    'nombre' => $nombre,
    'whatsapp' => $whatsapp,
    'email' => $email,
    'lead_score' => score_lead($tipoCode, $gastoCode, $plazoCode),
    'source_url' => $source,
    'utm_source' => clean_line(field($data, 'utm_source'), 120),
    'utm_medium' => clean_line(field($data, 'utm_medium'), 120),
    'utm_campaign' => clean_line(field($data, 'utm_campaign'), 120),
    'ip_hash' => ip_hash(),
    'kwp_estimado' => $kwp,
    'ahorro_estimado' => $ahorro,
    'origen_cta' => $origen,
    'pagina_tipo' => $paginaTipo,
    'plaza_id' => $tenant['plaza_id'],
];

try {
    $pdo = db();
    $since = (new DateTimeImmutable('-1 hour'))->format(DateTimeInterface::ATOM);
    $count = $pdo->prepare('SELECT COUNT(*) FROM leads WHERE ip_hash = ? AND created_at >= ?');
    $count->execute([$lead['ip_hash'], $since]);
    if ((int) $count->fetchColumn() >= 8) {
        lead_json(429, ['ok' => false, 'error' => 'Ya enviaste varias evaluaciones. Escríbenos por WhatsApp si falta una.']);
    }
    $insert = $pdo->prepare(
        'INSERT INTO leads (
            created_at, comuna, tipo_proyecto, gasto_luz, plazo, nombre, whatsapp, email,
            lead_score, estado, notas, source_url, utm_source, utm_medium, utm_campaign, ip_hash,
            kwp_estimado, ahorro_estimado, origen_cta, pagina_tipo, plaza_id
        ) VALUES (
            :created_at, :comuna, :tipo_proyecto, :gasto_luz, :plazo, :nombre, :whatsapp, :email,
            :lead_score, :estado, :notas, :source_url, :utm_source, :utm_medium, :utm_campaign, :ip_hash,
            :kwp_estimado, :ahorro_estimado, :origen_cta, :pagina_tipo, :plaza_id
        )'
    );
    $insert->execute([
        'created_at' => $lead['created_at'],
        'comuna' => $lead['comuna'],
        'tipo_proyecto' => $lead['tipo_proyecto'],
        'gasto_luz' => $lead['gasto_luz'],
        'plazo' => $lead['plazo'],
        'nombre' => $lead['nombre'],
        'whatsapp' => $lead['whatsapp'],
        'email' => $lead['email'],
        'lead_score' => $lead['lead_score'],
        'estado' => 'Nuevo',
        'notas' => '',
        'source_url' => $lead['source_url'],
        'utm_source' => $lead['utm_source'],
        'utm_medium' => $lead['utm_medium'],
        'utm_campaign' => $lead['utm_campaign'],
        'ip_hash' => $lead['ip_hash'],
        'kwp_estimado' => $lead['kwp_estimado'],
        'ahorro_estimado' => $lead['ahorro_estimado'],
        'origen_cta' => $lead['origen_cta'],
        'pagina_tipo' => $lead['pagina_tipo'],
        'plaza_id' => $lead['plaza_id'],
    ]);
} catch (Throwable $e) {
    error_log('Panel Solar Norte lead: ' . $e->getMessage());
    lead_json(500, ['ok' => false, 'error' => 'No pudimos registrar el proyecto. Escríbenos por WhatsApp.']);
}

try {
    notify_lead($lead, $comunaCode);
} catch (Throwable $e) {
    error_log('Panel Solar Norte alerta: ' . $e->getMessage());
}

lead_json(200, [
    'ok' => true,
    'whatsapp_destino' => $tenant['whatsapp'],
    'resumen' => [
        'nombre' => $lead['nombre'],
        'comuna' => $lead['comuna'],
        'tipo_proyecto' => $lead['tipo_proyecto'],
        'gasto_luz' => $lead['gasto_luz'],
        'plazo' => $lead['plazo'],
        'whatsapp' => $lead['whatsapp'],
        'kwp_estimado' => $lead['kwp_estimado'],
        'ahorro_estimado' => $lead['ahorro_estimado'],
    ],
]);

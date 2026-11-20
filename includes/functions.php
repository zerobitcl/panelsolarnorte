<?php
declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    ini_set('display_errors', '0');
    ini_set('log_errors', '1');
}

date_default_timezone_set('America/Santiago');

function site_config(): array
{
    static $config;
    if ($config === null) {
        $config = require dirname(__DIR__) . '/config.php';
    }
    return $config;
}

function comunas_principales(): array
{
    static $comunas;
    if ($comunas === null) {
        $comunas = require dirname(__DIR__) . '/data/comunas.php';
    }
    return $comunas;
}

function satelites(): array
{
    static $satelites;
    if ($satelites === null) {
        $file = dirname(__DIR__) . '/data/satelites.php';
        $satelites = is_file($file) ? require $file : [];
    }
    return $satelites;
}

function comunas(): array
{
    static $all;
    if ($all === null) {
        $all = comunas_principales() + satelites();
    }
    return $all;
}

function comunas_nav(): array
{
    return comunas_principales();
}

function servicios(): array
{
    static $servicios;
    if ($servicios === null) {
        $file = dirname(__DIR__) . '/data/servicios.php';
        $servicios = is_file($file) ? require $file : [];
    }
    return $servicios;
}

function guias(): array
{
    static $guias;
    if ($guias === null) {
        $file = dirname(__DIR__) . '/data/guias.php';
        $guias = is_file($file) ? require $file : [];
    }
    return $guias;
}

function satelites_de(string $madre): array
{
    $out = [];
    foreach (satelites() as $slug => $item) {
        if (($item['madre'] ?? '') === $madre) {
            $out[$slug] = $item;
        }
    }
    return $out;
}

function calc_params(string $slug): array
{
    $defaults = ['hsp' => 5.5, 'kwh_precio' => 265, 'factor_perdidas' => 0.82];
    $item = comunas()[$slug] ?? null;
    if (!is_array($item)) {
        return $defaults;
    }
    return [
        'hsp' => (float) ($item['hsp'] ?? $defaults['hsp']),
        'kwh_precio' => (float) ($item['kwh_precio'] ?? $defaults['kwh_precio']),
        'factor_perdidas' => (float) ($item['factor_perdidas'] ?? $defaults['factor_perdidas']),
    ];
}

/**
 * Resuelve la comuna madre de un slug (satélite → madre; principal → sí mismo).
 */
function comuna_madre_slug(string $slug): string
{
    $item = comunas()[$slug] ?? null;
    if (!is_array($item)) {
        return $slug;
    }
    $madre = (string) ($item['madre'] ?? '');
    if ($madre !== '' && isset(comunas()[$madre])) {
        return $madre;
    }
    return (string) ($item['slug'] ?? $slug);
}

/**
 * Plaza Rank & Rent asociada a una comuna (propia o satélite).
 * @return array{id:string,nombre:string,estado:string,arrendatario_nombre:string,whatsapp:string,email:string,user:string,vacante:bool}|null
 */
function plaza_for_comuna(?string $slug): ?array
{
    if ($slug === null || $slug === '' || $slug === 'otra') {
        return null;
    }
    $madre = comuna_madre_slug($slug);
    $plazas = site_config()['plazas'] ?? [];
    if (!is_array($plazas)) {
        return null;
    }
    foreach ($plazas as $id => $plaza) {
        if (!is_array($plaza)) {
            continue;
        }
        $madres = $plaza['comunas_madre'] ?? [];
        if (!is_array($madres)) {
            continue;
        }
        if (in_array($madre, $madres, true) || in_array($slug, $madres, true)) {
            $estado = (string) ($plaza['estado'] ?? 'vacante');
            $vacante = $estado !== 'activa'
                || trim((string) ($plaza['whatsapp'] ?? '')) === '';
            return [
                'id' => (string) $id,
                'nombre' => (string) ($plaza['nombre'] ?? $id),
                'estado' => $estado,
                'arrendatario_nombre' => (string) ($plaza['arrendatario_nombre'] ?? ''),
                'whatsapp' => (string) ($plaza['whatsapp'] ?? ''),
                'email' => (string) ($plaza['email'] ?? ''),
                'user' => (string) ($plaza['user'] ?? ''),
                'vacante' => $vacante,
            ];
        }
    }
    return null;
}

/**
 * Destino de contacto (WhatsApp + email) para una comuna.
 * Si la plaza está vacante, cae a administración.
 * @return array{whatsapp:string,email:string,nombre:string,plaza_id:string,vacante:bool}
 */
function tenant_for_comuna(?string $slug): array
{
    $config = site_config();
    $fallbackWa = preg_replace('/\D+/', '', (string) ($config['whatsapp'] ?? '')) ?: '';
    $fallbackEmail = (string) ($config['alert_email'] ?? '');
    $plaza = plaza_for_comuna($slug ?? '');
    if ($plaza === null || $plaza['vacante']) {
        return [
            'whatsapp' => $fallbackWa,
            'email' => $fallbackEmail,
            'nombre' => 'Administración',
            'plaza_id' => $plaza['id'] ?? '',
            'vacante' => true,
        ];
    }
    $wa = preg_replace('/\D+/', '', $plaza['whatsapp']) ?: $fallbackWa;
    $email = $plaza['email'] !== '' ? $plaza['email'] : $fallbackEmail;
    return [
        'whatsapp' => $wa,
        'email' => $email,
        'nombre' => $plaza['arrendatario_nombre'] !== '' ? $plaza['arrendatario_nombre'] : 'Instalador de zona',
        'plaza_id' => $plaza['id'],
        'vacante' => false,
    ];
}

function plazas_disponibles(): array
{
    $out = [];
    foreach (site_config()['plazas'] ?? [] as $id => $plaza) {
        if (!is_array($plaza)) {
            continue;
        }
        if (($plaza['estado'] ?? '') === 'vacante' || trim((string) ($plaza['whatsapp'] ?? '')) === '') {
            $out[$id] = $plaza + ['id' => $id];
        }
    }
    return $out;
}

/**
 * Estimación orientativa on-grid. Rangos, nunca una cifra cerrada.
 * @return array{kwp:float,paneles:int,m2:float,ahorro_min:int,ahorro_max:int,payback_min:float,payback_max:float,gasto_code:string}
 */
function calc_estimate(string $slug, int $boleta, string $uso = 'casa'): array
{
    $boleta = max(30000, min(500000, $boleta));
    $p = calc_params($slug);
    $usoFactor = match ($uso) {
        'empresa' => 0.72,
        'parcela' => 0.45,
        'bombeo' => 0.55,
        default => 0.58,
    };
    $kwhMes = $boleta / max(1.0, $p['kwh_precio']);
    $kwhDia = $kwhMes / 30;
    $kwp = ($kwhDia * $usoFactor) / max(0.1, $p['hsp'] * $p['factor_perdidas']);
    $kwp = round(max(1.5, min(15.0, $kwp)) * 2) / 2;
    $panelW = 550;
    $paneles = (int) max(3, (int) ceil(($kwp * 1000) / $panelW));
    $m2 = round($paneles * 2.4, 1);
    $produccionAnual = $kwp * $p['hsp'] * $p['factor_perdidas'] * 365;
    $autoconsumo = match ($uso) {
        'empresa' => 0.78,
        'bombeo' => 0.85,
        'parcela' => 0.4,
        default => 0.62,
    };
    $ahorroBase = (int) round($produccionAnual * $autoconsumo * $p['kwh_precio']);
    $ahorroMin = (int) round($ahorroBase * 0.85);
    $ahorroMax = (int) round($ahorroBase * 1.1);
    $capex = (int) round($kwp * 950000);
    $paybackMin = round($capex / max(1, $ahorroMax), 1);
    $paybackMax = round($capex / max(1, $ahorroMin), 1);
    $gastoCode = $boleta < 50000 ? 'menos_50' : ($boleta <= 120000 ? '50_120' : 'mas_120');
    return [
        'kwp' => $kwp,
        'paneles' => $paneles,
        'm2' => $m2,
        'ahorro_min' => $ahorroMin,
        'ahorro_max' => $ahorroMax,
        'payback_min' => $paybackMin,
        'payback_max' => $paybackMax,
        'gasto_code' => $gastoCode,
    ];
}

function format_clp(int $n): string
{
    return '$' . number_format($n, 0, ',', '.');
}

function sitemap_entries(): array
{
    $entries = [
        ['loc' => '/', 'lastmod' => '2026-11-20', 'priority' => '1.0'],
        ['loc' => '/servicios', 'lastmod' => '2026-11-20', 'priority' => '0.9'],
        ['loc' => '/guias', 'lastmod' => '2026-11-20', 'priority' => '0.85'],
        ['loc' => '/instaladores', 'lastmod' => '2026-11-20', 'priority' => '0.4'],
    ];
    foreach (comunas() as $item) {
        $entries[] = [
            'loc' => $item['path'],
            'lastmod' => (string) ($item['lastmod'] ?? '2026-11-20'),
            'priority' => (($item['nivel'] ?? '') === 'satelite') ? '0.7' : '0.9',
        ];
    }
    foreach (servicios() as $item) {
        $entries[] = [
            'loc' => $item['path'],
            'lastmod' => (string) ($item['lastmod'] ?? '2026-11-20'),
            'priority' => '0.85',
        ];
    }
    foreach (guias() as $item) {
        $entries[] = [
            'loc' => $item['path'],
            'lastmod' => (string) ($item['lastmod'] ?? '2026-11-20'),
            'priority' => '0.75',
        ];
    }
    return $entries;
}

function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function base_url(): string
{
    return rtrim((string) site_config()['base_url'], '/');
}

function absolute_url(string $path): string
{
    if ($path === '' || $path === '/') {
        return base_url() . '/';
    }
    return base_url() . '/' . ltrim($path, '/');
}

function json_ld(array $data): string
{
    $json = json_encode(
        $data,
        JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT
    );
    if ($json === false) {
        return '';
    }
    return '<script type="application/ld+json">' . $json . '</script>';
}

function icon(string $name): string
{
    $paths = [
        'sun' => '<circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4"/>',
        'bolt' => '<path d="M13 2 4 14h7l-1 8 9-12h-7l1-8z"/>',
        'drop' => '<path d="M12 2.5s6 6.2 6 10.2a6 6 0 0 1-12 0C6 8.7 12 2.5 12 2.5z"/>',
        'home' => '<path d="M4 10.5 12 4l8 6.5V20a1 1 0 0 1-1 1h-5v-6H10v6H5a1 1 0 0 1-1-1v-9.5z"/>',
        'shield' => '<path d="M12 3 5 6v6c0 4.2 2.8 7.2 7 8.5 4.2-1.3 7-4.3 7-8.5V6l-7-3z"/><path d="m9 12 2 2 4-4"/>',
        'pin' => '<path d="M12 21s7-6.1 7-11a7 7 0 1 0-14 0c0 4.9 7 11 7 11z"/><circle cx="12" cy="10" r="2.5"/>',
        'grid' => '<path d="M4 7h16M4 12h16M4 17h10"/>',
        'check' => '<path d="M20 6 9 17l-5-5"/>',
        'clock' => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
        'calc' => '<rect x="4" y="3" width="16" height="18" rx="2"/><path d="M8 7h8M8 12h2M12 12h2M16 12h0M8 16h2M12 16h2M16 16h0"/>',
        'building' => '<path d="M4 20h16M6 20V8l6-4 6 4v12M10 12h4M10 16h4"/>',
    ];
    $body = $paths[$name] ?? $paths['sun'];
    return '<svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $body . '</svg>';
}

function lead_catalog(): array
{
    $comunas = [];
    foreach (comunas() as $slug => $item) {
        $comunas[$slug] = (string) $item['nombre'];
    }
    $comunas['otra'] = 'Otra comuna IV/III Región';
    return [
        'comunas' => $comunas,
        'tipos' => [
            'ongrid' => 'Casa con red eléctrica (Ahorro boleta / On-Grid)',
            'offgrid' => 'Parcela sin luz eléctrica (Kit Off-Grid con baterías)',
            'bombeo' => 'Campo / Riego agrícola (Bombeo Solar)',
            'empresa' => 'Empresa / Pyme / Faena',
        ],
        'gastos' => [
            'menos_50' => 'Menos de $50.000',
            '50_120' => '$50.000 a $120.000',
            'mas_120' => 'Más de $120.000',
            'sin_empalme' => 'No tengo empalme aún',
        ],
        'plazos' => [
            'asap' => 'Lo antes posible (este mes)',
            '1_3' => 'En 1 a 3 meses',
            'cotizando' => 'Solo estoy cotizando',
        ],
        'estados' => ['Nuevo', 'Contactado', 'Cotizado', 'Vendido', 'Descartado'],
    ];
}

function score_lead(string $tipo, string $gasto, string $plazo): string
{
    if ($gasto === 'mas_120') {
        return 'ALTO';
    }
    if (in_array($tipo, ['offgrid', 'bombeo'], true) && $plazo === 'asap') {
        return 'ALTO';
    }
    if ($tipo === 'empresa' && $plazo === 'asap') {
        return 'ALTO';
    }
    if ($plazo === 'cotizando') {
        return 'BAJO';
    }
    if ($plazo === 'asap' && $gasto === '50_120') {
        return 'ALTO';
    }
    if ($plazo === '1_3' && ($gasto === '50_120' || in_array($tipo, ['offgrid', 'bombeo', 'empresa'], true))) {
        return 'MEDIO';
    }
    if ($gasto === '50_120') {
        return 'MEDIO';
    }
    return 'BAJO';
}

function normalize_phone(string $input): ?string
{
    $digits = preg_replace('/\D+/', '', $input);
    if (!is_string($digits)) {
        return null;
    }
    if (str_starts_with($digits, '56')) {
        $digits = substr($digits, 2);
    }
    if (strlen($digits) === 9 && str_starts_with($digits, '9')) {
        return '+56 9 ' . substr($digits, 1, 4) . ' ' . substr($digits, 5, 4);
    }
    return null;
}

function phone_digits(string $normalized): string
{
    $digits = preg_replace('/\D+/', '', $normalized);
    return is_string($digits) ? $digits : '';
}

function valid_email(string $email): bool
{
    if ($email === '' || preg_match('/[\r\n]/', $email) === 1) {
        return false;
    }
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function clean_line(string $value, int $max): string
{
    $value = trim(preg_replace('/[\r\n\t]+/', ' ', $value) ?? '');
    if (strlen($value) > $max) {
        $value = substr($value, 0, $max);
    }
    return $value;
}

function request_is_https(): bool
{
    if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
        return true;
    }
    $proto = strtolower((string) ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? ''));
    return $proto === 'https' || (string) ($_SERVER['SERVER_PORT'] ?? '') === '443';
}

function session_boot(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }
    session_name('PSNSESS');
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'secure' => request_is_https(),
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

function csrf_token(): string
{
    session_boot();
    if (empty($_SESSION['csrf']) || !is_string($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function csrf_ok(?string $token): bool
{
    session_boot();
    $known = $_SESSION['csrf'] ?? '';
    return is_string($known) && is_string($token) && $known !== '' && hash_equals($known, $token);
}

function current_user(): ?array
{
    session_boot();
    $user = $_SESSION['user'] ?? null;
    return is_array($user) ? $user : null;
}

function client_ip(): string
{
    $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    return is_string($ip) && $ip !== '' ? $ip : '0.0.0.0';
}

function ip_hash(): string
{
    return hash('sha256', client_ip() . '|' . (string) site_config()['ip_salt']);
}

function db(): PDO
{
    static $pdo;
    if ($pdo instanceof PDO) {
        return $pdo;
    }
    if (!extension_loaded('pdo_sqlite')) {
        throw new RuntimeException('PDO SQLite no está habilitado en este PHP.');
    }
    $dir = dirname(__DIR__) . '/data';
    if (!is_dir($dir) && !mkdir($dir, 0755, true) && !is_dir($dir)) {
        throw new RuntimeException('No se pudo crear el directorio de datos.');
    }
    $pdo = new PDO('sqlite:' . $dir . '/leads.sqlite', null, null, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    $pdo->exec('PRAGMA busy_timeout = 3000');
    $pdo->exec('PRAGMA foreign_keys = ON');
    try {
        $pdo->exec('PRAGMA journal_mode = WAL');
    } catch (Throwable $e) {
        // En discos de red el modo WAL puede fallar; SQLite sigue en journal delete.
    }
    $pdo->exec(
        'CREATE TABLE IF NOT EXISTS leads (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            created_at TEXT NOT NULL,
            comuna TEXT NOT NULL,
            tipo_proyecto TEXT NOT NULL,
            gasto_luz TEXT NOT NULL,
            plazo TEXT NOT NULL,
            nombre TEXT NOT NULL,
            whatsapp TEXT NOT NULL,
            email TEXT,
            lead_score TEXT NOT NULL,
            estado TEXT NOT NULL DEFAULT \'Nuevo\',
            notas TEXT,
            source_url TEXT,
            utm_source TEXT,
            utm_medium TEXT,
            utm_campaign TEXT,
            ip_hash TEXT
        )'
    );
    $existing = array_column($pdo->query('PRAGMA table_info(leads)')->fetchAll(), 'name');
    foreach ([
        'utm_medium', 'utm_campaign', 'source_url', 'ip_hash', 'notas',
        'kwp_estimado', 'ahorro_estimado', 'origen_cta', 'pagina_tipo', 'plaza_id',
    ] as $column) {
        if (!in_array($column, $existing, true)) {
            $pdo->exec('ALTER TABLE leads ADD COLUMN ' . $column . ' TEXT');
        }
    }
    $pdo->exec(
        'CREATE TABLE IF NOT EXISTS wa_clicks (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            created_at TEXT NOT NULL,
            comuna TEXT,
            origen_cta TEXT,
            source_url TEXT,
            pagina_tipo TEXT,
            plaza_id TEXT,
            ip_hash TEXT
        )'
    );
    $pdo->exec('CREATE INDEX IF NOT EXISTS idx_leads_created ON leads(created_at)');
    $pdo->exec('CREATE INDEX IF NOT EXISTS idx_leads_comuna ON leads(comuna)');
    $pdo->exec('CREATE INDEX IF NOT EXISTS idx_leads_ip ON leads(ip_hash, created_at)');
    $pdo->exec('CREATE INDEX IF NOT EXISTS idx_wa_clicks_created ON wa_clicks(created_at)');
    return $pdo;
}

function zona_nombres(array $user): array
{
    $catalog = lead_catalog()['comunas'];
    if (($user['role'] ?? '') === 'admin') {
        return array_values($catalog);
    }
    $allowed = $user['zonas'] ?? [];
    $names = [];
    foreach ($catalog as $slug => $name) {
        if ($slug === 'otra') {
            continue;
        }
        $item = comunas()[$slug] ?? null;
        $madre = is_array($item) ? (string) ($item['madre'] ?? $slug) : $slug;
        $own = is_array($item) ? (string) ($item['slug'] ?? $slug) : $slug;
        if (in_array($own, $allowed, true) || in_array($madre, $allowed, true)) {
            $names[] = $name;
        }
    }
    return array_values(array_unique($names));
}

function lead_kpis(array $names): array
{
    $empty = [
        'total' => 0,
        'mes' => 0,
        'altos' => 0,
        'altos_mes' => 0,
        'vendidos' => 0,
        'conversion' => 0.0,
        'kwp_mes' => 0.0,
        'wa_clicks_mes' => 0,
        'por_comuna' => [],
        'por_origen' => [],
    ];
    if ($names === []) {
        return $empty;
    }
    $pdo = db();
    $month = (new DateTimeImmutable('now'))->format('Y-m');
    $namesForIn = [];
    $in = in_clause($names, $namesForIn);
    $stmt = $pdo->prepare(
        "SELECT
            COUNT(*) AS total,
            SUM(CASE WHEN substr(created_at, 1, 7) = ? THEN 1 ELSE 0 END) AS mes,
            SUM(CASE WHEN lead_score = 'ALTO' THEN 1 ELSE 0 END) AS altos,
            SUM(CASE WHEN lead_score = 'ALTO' AND substr(created_at, 1, 7) = ? THEN 1 ELSE 0 END) AS altos_mes,
            SUM(CASE WHEN estado = 'Vendido' THEN 1 ELSE 0 END) AS vendidos,
            SUM(CASE WHEN substr(created_at, 1, 7) = ? AND kwp_estimado IS NOT NULL AND kwp_estimado != ''
                THEN CAST(REPLACE(kwp_estimado, ',', '.') AS REAL) ELSE 0 END) AS kwp_mes
         FROM leads WHERE comuna IN ($in)"
    );
    $stmt->execute(array_merge([$month, $month, $month], $names));
    $row = $stmt->fetch() ?: [];
    $total = (int) ($row['total'] ?? 0);
    $vendidos = (int) ($row['vendidos'] ?? 0);
    $por = [];
    $group = $pdo->prepare("SELECT comuna, COUNT(*) AS total FROM leads WHERE comuna IN ($in) GROUP BY comuna");
    $group->execute($names);
    foreach ($group->fetchAll() as $item) {
        $por[] = ['comuna' => (string) $item['comuna'], 'total' => (int) $item['total']];
    }
    usort($por, static fn (array $a, array $b): int => $b['total'] <=> $a['total']);
    $porOrigen = [];
    $origenStmt = $pdo->prepare("SELECT COALESCE(NULLIF(origen_cta, ''), 'hero') AS origen, COUNT(*) AS total FROM leads WHERE comuna IN ($in) GROUP BY origen");
    $origenStmt->execute($names);
    foreach ($origenStmt->fetchAll() as $item) {
        $porOrigen[] = ['origen' => (string) $item['origen'], 'total' => (int) $item['total']];
    }
    usort($porOrigen, static fn (array $a, array $b): int => $b['total'] <=> $a['total']);

    $waClicks = 0;
    try {
        $waStmt = $pdo->prepare("SELECT COUNT(*) FROM wa_clicks WHERE substr(created_at, 1, 7) = ? AND (comuna IN ($in) OR comuna IS NULL OR comuna = '' OR comuna = 'Sin comuna')");
        $waStmt->execute(array_merge([$month], $names));
        $waClicks = (int) $waStmt->fetchColumn();
    } catch (Throwable $e) {
        $waClicks = 0;
    }

    return [
        'total' => $total,
        'mes' => (int) ($row['mes'] ?? 0),
        'altos' => (int) ($row['altos'] ?? 0),
        'altos_mes' => (int) ($row['altos_mes'] ?? 0),
        'vendidos' => $vendidos,
        'conversion' => $total > 0 ? round(($vendidos / $total) * 100, 1) : 0.0,
        'kwp_mes' => round((float) ($row['kwp_mes'] ?? 0), 1),
        'wa_clicks_mes' => $waClicks,
        'por_comuna' => $por,
        'por_origen' => $porOrigen,
    ];
}

function in_clause(array $values, array &$params): string
{
    foreach ($values as $value) {
        $params[] = $value;
    }
    return implode(',', array_fill(0, count($values), '?'));
}

function fetch_leads(array $user, array $filters = []): array
{
    $names = zona_nombres($user);
    if ($names === []) {
        return [];
    }
    $params = [];
    $where = ['comuna IN (' . in_clause($names, $params) . ')'];
    $comuna = (string) ($filters['comuna'] ?? '');
    if ($comuna !== '' && in_array($comuna, $names, true)) {
        $where[] = 'comuna = ?';
        $params[] = $comuna;
    }
    $score = (string) ($filters['score'] ?? '');
    if (in_array($score, ['ALTO', 'MEDIO', 'BAJO'], true)) {
        $where[] = 'lead_score = ?';
        $params[] = $score;
    }
    $estado = (string) ($filters['estado'] ?? '');
    if (in_array($estado, lead_catalog()['estados'], true)) {
        $where[] = 'estado = ?';
        $params[] = $estado;
    }
    $q = clean_line((string) ($filters['q'] ?? ''), 80);
    if ($q !== '') {
        $where[] = '(nombre LIKE ? OR whatsapp LIKE ?)';
        $params[] = '%' . $q . '%';
        $params[] = '%' . $q . '%';
    }
    $sql = 'SELECT id, created_at, comuna, tipo_proyecto, gasto_luz, plazo, nombre, whatsapp, email, lead_score, estado, notas, source_url, utm_source, utm_medium, utm_campaign, kwp_estimado, ahorro_estimado, origen_cta, pagina_tipo
            FROM leads WHERE ' . implode(' AND ', $where) . ' ORDER BY id DESC LIMIT 500';
    $stmt = db()->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function update_lead(array $user, int $id, string $estado, string $notas): bool
{
    if (!in_array($estado, lead_catalog()['estados'], true) || $id < 1) {
        return false;
    }
    $names = zona_nombres($user);
    if ($names === []) {
        return false;
    }
    $notas = trim(strip_tags($notas));
    if (strlen($notas) > 1000) {
        $notas = substr($notas, 0, 1000);
    }
    $params = [$estado, $notas, $id];
    $in = in_clause($names, $params);
    $stmt = db()->prepare("UPDATE leads SET estado = ?, notas = ? WHERE id = ? AND comuna IN ($in)");
    $stmt->execute($params);
    return $stmt->rowCount() > 0;
}

function notify_lead(array $lead, string $slug): void
{
    if (PHP_OS_FAMILY === 'Windows') {
        error_log('Panel Solar Norte: alerta por correo omitida en Windows. En Hostinger se envía con mail().');
        return;
    }
    $config = site_config();
    $madre = comuna_madre_slug($slug);
    $tenant = tenant_for_comuna($slug);
    $recipients = [(string) $config['alert_email']];
    if ($tenant['email'] !== '' && valid_email($tenant['email'])) {
        $recipients[] = $tenant['email'];
    }
    foreach ($config['users'] as $user) {
        if (($user['role'] ?? '') !== 'instalador') {
            continue;
        }
        $zonas = $user['zonas'] ?? [];
        if (!in_array($slug, $zonas, true) && !in_array($madre, $zonas, true)) {
            continue;
        }
        if (!empty($user['email'])) {
            $recipients[] = (string) $user['email'];
        }
    }
    $recipients = array_values(array_unique(array_filter($recipients, static function (string $email): bool {
        return valid_email($email);
    })));
    if ($recipients === []) {
        return;
    }
    $digits = phone_digits((string) $lead['whatsapp']);
    $vacanteTag = $tenant['vacante'] ? ' [PLAZA VACANTE]' : '';
    $subject = '[' . $lead['lead_score'] . ']' . $vacanteTag . ' Lead solar ' . $lead['comuna'] . ' — ' . $lead['nombre'];
    $subject = clean_line($subject, 140);
    $body = "Entró un proyecto en Panel Solar Norte.\n\n"
        . 'Prioridad: ' . $lead['lead_score'] . "\n"
        . 'Comuna: ' . $lead['comuna'] . "\n"
        . 'Plaza: ' . ($tenant['plaza_id'] !== '' ? $tenant['plaza_id'] : 'sin plaza') . ($tenant['vacante'] ? ' (vacante → admin)' : '') . "\n"
        . 'Tipo: ' . $lead['tipo_proyecto'] . "\n"
        . 'Gasto de luz: ' . $lead['gasto_luz'] . "\n"
        . 'Plazo: ' . $lead['plazo'] . "\n"
        . 'Nombre: ' . $lead['nombre'] . "\n"
        . 'WhatsApp: ' . $lead['whatsapp'] . "\n"
        . 'Email: ' . ($lead['email'] !== '' ? $lead['email'] : 'no indicó') . "\n"
        . 'kWp estimado: ' . ($lead['kwp_estimado'] !== '' ? $lead['kwp_estimado'] : '-') . "\n"
        . 'Origen CTA: ' . ($lead['origen_cta'] !== '' ? $lead['origen_cta'] : '-') . "\n"
        . 'Origen URL: ' . $lead['source_url'] . "\n"
        . 'UTM source: ' . ($lead['utm_source'] !== '' ? $lead['utm_source'] : '-') . "\n"
        . 'Fecha: ' . $lead['created_at'] . "\n\n"
        . ($digits !== '' ? 'Abrir chat: https://wa.me/' . $digits . "\n" : '');
    $from = (string) $config['from_email'];
    $headers = [
        'MIME-Version: 1.0',
        'Content-Type: text/plain; charset=UTF-8',
        'From: Panel Solar Norte <' . clean_line($from, 120) . '>',
    ];
    if (!empty($lead['email'])) {
        $headers[] = 'Reply-To: ' . clean_line((string) $lead['email'], 160);
    }
    $headerText = implode("\r\n", $headers);
    $envelope = valid_email($from) ? '-f ' . $from : '';
    foreach ($recipients as $to) {
        $sent = $envelope !== ''
            ? @mail($to, '=?UTF-8?B?' . base64_encode($subject) . '?=', $body, $headerText, $envelope)
            : @mail($to, '=?UTF-8?B?' . base64_encode($subject) . '?=', $body, $headerText);
        if ($sent !== true) {
            error_log('Panel Solar Norte: no se pudo enviar la alerta de lead a ' . $to);
        }
    }
}

function schema_graph(array $options): array
{
    $config = site_config();
    $path = (string) ($options['path'] ?? '/');
    $url = absolute_url($path);
    $orgId = absolute_url('/') . '#organizacion';
    $articleOnly = !empty($options['article_only']);
    $graph = [
        [
            '@type' => 'Organization',
            '@id' => $orgId,
            'name' => $config['site_name'],
            'url' => absolute_url('/'),
            'telephone' => '+' . preg_replace('/\D+/', '', (string) $config['whatsapp']),
            'areaServed' => [
                ['@type' => 'AdministrativeArea', 'name' => 'Región de Coquimbo'],
                ['@type' => 'AdministrativeArea', 'name' => 'Región de Atacama'],
            ],
        ],
    ];

    if (!$articleOnly) {
        $areas = [];
        foreach ($options['areas'] ?? [] as $area) {
            $areas[] = [
                '@type' => $area['type'],
                'name' => $area['name'],
                'addressCountry' => 'CL',
            ];
        }
        $services = [];
        foreach ($options['services'] ?? [] as $service) {
            $services[] = [
                '@type' => 'Service',
                'name' => $service,
                'serviceType' => 'Instalación fotovoltaica',
                'areaServed' => $areas,
                'provider' => ['@id' => $url . '#negocio'],
            ];
        }
        $graph[] = [
            '@type' => ['HomeAndConstructionBusiness', 'LocalBusiness'],
            '@id' => $url . '#negocio',
            'name' => $config['site_name'],
            'url' => $url,
            'description' => $options['description'],
            'telephone' => '+' . preg_replace('/\D+/', '', (string) $config['whatsapp']),
            'areaServed' => $areas,
            'parentOrganization' => ['@id' => $orgId],
            'address' => [
                '@type' => 'PostalAddress',
                'addressLocality' => $options['locality'] ?? 'La Serena',
                'addressRegion' => $options['region'] ?? 'Coquimbo',
                'addressCountry' => 'CL',
            ],
            'makesOffer' => array_map(static function (array $service): array {
                return [
                    '@type' => 'Offer',
                    'itemOffered' => $service,
                    'areaServed' => $service['areaServed'],
                ];
            }, $services),
        ];
    }

    if (!empty($options['crumbs'])) {
        $items = [];
        $pos = 1;
        $items[] = [
            '@type' => 'ListItem',
            'position' => $pos++,
            'name' => 'Inicio',
            'item' => absolute_url('/'),
        ];
        if (!empty($options['crumb_mid']) && is_array($options['crumb_mid'])) {
            $items[] = [
                '@type' => 'ListItem',
                'position' => $pos++,
                'name' => (string) $options['crumb_mid']['name'],
                'item' => absolute_url((string) $options['crumb_mid']['path']),
            ];
        }
        $items[] = [
            '@type' => 'ListItem',
            'position' => $pos,
            'name' => (string) ($options['crumb_current'] ?? ('Paneles Solares ' . ($options['locality'] ?? ''))),
            'item' => $url,
        ];
        $graph[] = [
            '@type' => 'BreadcrumbList',
            'itemListElement' => $items,
        ];
    }
    if (!empty($options['article'])) {
        $graph[] = [
            '@type' => $options['article']['@type'] ?? 'Article',
            'headline' => $options['article']['headline'],
            'description' => $options['description'],
            'dateModified' => $options['article']['dateModified'] ?? '2026-11-20',
            'author' => ['@id' => $orgId],
            'publisher' => ['@id' => $orgId],
            'mainEntityOfPage' => $url,
        ];
    }
    if (!empty($options['howto']) && is_array($options['howto'])) {
        $steps = [];
        foreach ($options['howto'] as $i => $step) {
            $steps[] = [
                '@type' => 'HowToStep',
                'position' => $i + 1,
                'name' => $step['name'],
                'text' => $step['text'],
            ];
        }
        $graph[] = [
            '@type' => 'HowTo',
            'name' => $options['article']['headline'] ?? ($options['locality'] ?? 'Guía'),
            'description' => $options['description'],
            'step' => $steps,
        ];
    }
    if (!empty($options['faqs'])) {
        $questions = [];
        foreach ($options['faqs'] as $faq) {
            $questions[] = [
                '@type' => 'Question',
                'name' => $faq['q'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $faq['a'],
                ],
            ];
        }
        $graph[] = [
            '@type' => 'FAQPage',
            'mainEntity' => $questions,
        ];
    }
    return [
        '@context' => 'https://schema.org',
        '@graph' => $graph,
    ];
}

function faq_plain(array $faqs): array
{
    $plain = [];
    foreach ($faqs as $faq) {
        $plain[] = [
            'q' => $faq['q'],
            'a' => trim($faq['a'] . (isset($faq['extra']) ? ' ' . $faq['extra'] : '')),
        ];
    }
    return $plain;
}

function input_data(): array
{
    $type = strtolower((string) ($_SERVER['CONTENT_TYPE'] ?? ''));
    if (str_contains($type, 'application/json')) {
        $decoded = json_decode(file_get_contents('php://input') ?: '', true);
        return is_array($decoded) ? $decoded : [];
    }
    return $_POST;
}

function field(array $source, string $key): string
{
    $value = $source[$key] ?? '';
    if (is_int($value) || is_float($value)) {
        return (string) $value;
    }
    return is_string($value) ? trim($value) : '';
}

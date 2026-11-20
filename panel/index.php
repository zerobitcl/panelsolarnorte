<?php
declare(strict_types=1);

require dirname(__DIR__) . '/includes/functions.php';

header('Cache-Control: no-store');
header('X-Content-Type-Options: nosniff');
header('X-Robots-Tag: noindex, nofollow');

session_boot();

function panel_back(string $candidate): string
{
    $candidate = str_replace(["\r", "\n"], '', $candidate);
    if (!str_starts_with($candidate, '/panel') || str_contains($candidate, '://') || str_contains($candidate, '\\')) {
        return '/panel/';
    }
    return $candidate;
}

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $action = field($_POST, 'action');
    if (!csrf_ok(field($_POST, 'csrf'))) {
        $_SESSION['flash'] = 'La sesión expiró. Vuelve a intentar.';
        header('Location: /panel/', true, 303);
        exit;
    }
    if ($action === 'logout') {
        $_SESSION = [];
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'] ?? '', (bool) $params['secure'], (bool) $params['httponly']);
        session_destroy();
        header('Location: /panel/', true, 303);
        exit;
    }
    if ($action === 'login') {
        $lockedUntil = (int) ($_SESSION['login_lock'] ?? 0);
        if ($lockedUntil > time()) {
            $_SESSION['flash'] = 'Demasiados intentos. Espera 5 minutos.';
            header('Location: /panel/', true, 303);
            exit;
        }
        $username = field($_POST, 'username');
        $password = (string) ($_POST['password'] ?? '');
        $users = site_config()['users'];
        $record = $users[$username] ?? null;
        $hash = is_array($record) ? (string) ($record['password_hash'] ?? '') : '$2y$12$D1ummyHashNotRealUsedOnlyForTiming00';
        $valid = password_verify($password, $hash);
        if (!is_array($record) || !$valid) {
            $fails = (int) ($_SESSION['login_fails'] ?? 0) + 1;
            $_SESSION['login_fails'] = $fails;
            if ($fails >= 6) {
                $_SESSION['login_lock'] = time() + 300;
                $_SESSION['login_fails'] = 0;
            }
            $_SESSION['flash'] = 'Usuario o contraseña incorrectos.';
            header('Location: /panel/', true, 303);
            exit;
        }
        session_regenerate_id(true);
        unset($_SESSION['login_fails'], $_SESSION['login_lock']);
        $_SESSION['user'] = [
            'username' => $username,
            'role' => $record['role'],
            'name' => $record['name'],
            'email' => $record['email'],
            'zonas' => $record['zonas'],
        ];
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
        header('Location: /panel/', true, 303);
        exit;
    }
    if ($action === 'update') {
        $user = current_user();
        $back = panel_back(field($_POST, 'back'));
        if ($user === null) {
            header('Location: /panel/', true, 303);
            exit;
        }
        $ok = update_lead($user, (int) field($_POST, 'id'), field($_POST, 'estado'), field($_POST, 'notas'));
        $_SESSION['flash'] = $ok ? 'Lead actualizado.' : 'No se pudo actualizar ese lead.';
        header('Location: ' . $back, true, 303);
        exit;
    }
}

$user = current_user();
$flash = '';
if (isset($_SESSION['flash']) && is_string($_SESSION['flash'])) {
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
}

$page = [
    'title' => 'Panel de leads | Panel Solar Norte',
    'description' => 'Gestión interna de evaluaciones solares.',
    'path' => '/panel/',
    'robots' => 'noindex, nofollow',
    'panel' => true,
    'slug' => '',
];

$filters = [
    'comuna' => is_string($_GET['comuna'] ?? null) ? $_GET['comuna'] : '',
    'score' => is_string($_GET['score'] ?? null) ? $_GET['score'] : '',
    'estado' => is_string($_GET['estado'] ?? null) ? $_GET['estado'] : '',
    'q' => is_string($_GET['q'] ?? null) ? $_GET['q'] : '',
];

require dirname(__DIR__) . '/includes/head.php';
require dirname(__DIR__) . '/includes/header.php';
?>
<main id="contenido" class="section panel">
  <div class="wrap">
    <?php if ($user === null): ?>
      <div class="login-card">
        <p class="eyebrow">Acceso interno</p>
        <h1>Panel de leads</h1>
        <p>Entra con el usuario de administración o con el de tu zona. Cada instalador ve solo sus comunas.</p>
        <?php if ($flash !== ''): ?><p class="form-error" role="alert"><?= e($flash) ?></p><?php endif; ?>
        <form method="post" action="/panel/" class="login-form">
          <input type="hidden" name="action" value="login">
          <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
          <label class="field" for="username">Usuario
            <input id="username" name="username" type="text" autocomplete="username" required maxlength="40">
          </label>
          <label class="field" for="password">Contraseña
            <input id="password" name="password" type="password" autocomplete="current-password" required>
          </label>
          <button class="btn btn-amber" type="submit">Entrar</button>
        </form>
      </div>
    <?php else: ?>
      <?php
        $names = zona_nombres($user);
        $kpis = lead_kpis($names);
        $leads = fetch_leads($user, $filters);
        $isAdmin = ($user['role'] ?? '') === 'admin';
        $token = csrf_token();
        $back = panel_back($_SERVER['REQUEST_URI'] ?? '/panel/');
        $query = $_GET;
        unset($query['export']);
        $export = '/api/leads-admin.php?export=csv';
        if ($query !== []) {
            $export .= '&' . http_build_query($query);
        }
      ?>
      <div class="panel-top">
        <div>
          <p class="eyebrow"><?= $isAdmin ? 'Vista administración' : 'Vista instalador' ?></p>
          <h1><?= e((string) $user['name']) ?></h1>
          <p>Comunas: <?= e(implode(', ', $names)) ?>.</p>
        </div>
        <form method="post" action="/panel/">
          <input type="hidden" name="action" value="logout">
          <input type="hidden" name="csrf" value="<?= e($token) ?>">
          <button class="btn btn-ghost" type="submit">Salir</button>
        </form>
      </div>
      <?php if ($flash !== ''): ?><p class="flash" role="status"><?= e($flash) ?></p><?php endif; ?>

      <div class="kpi-grid">
        <article class="kpi">
          <p>Leads del mes</p>
          <strong data-kpi="mes"><?= e((string) $kpis['mes']) ?></strong>
        </article>
        <article class="kpi">
          <p>Prioridad alta (mes)</p>
          <strong data-kpi="altos_mes"><?= e((string) ($kpis['altos_mes'] ?? 0)) ?></strong>
        </article>
        <article class="kpi">
          <p>kWp estimados (mes)</p>
          <strong data-kpi="kwp_mes"><?= e(number_format((float) ($kpis['kwp_mes'] ?? 0), 1, ',', '')) ?></strong>
        </article>
        <article class="kpi">
          <p>Clics WhatsApp (mes)</p>
          <strong data-kpi="wa_clicks_mes"><?= e((string) ($kpis['wa_clicks_mes'] ?? 0)) ?></strong>
        </article>
        <?php if ($isAdmin): ?>
          <article class="kpi">
            <p>Total de leads</p>
            <strong data-kpi="total"><?= e((string) $kpis['total']) ?></strong>
          </article>
          <article class="kpi">
            <p>Prioridad alta (total)</p>
            <strong data-kpi="altos"><?= e((string) $kpis['altos']) ?></strong>
          </article>
          <article class="kpi">
            <p>Conversión a vendido</p>
            <strong data-kpi="conversion"><?= e(number_format((float) $kpis['conversion'], 1, ',', '')) ?>%</strong>
          </article>
        <?php endif; ?>
      </div>

      <?php if ($isAdmin && $kpis['por_comuna'] !== []): ?>
        <div class="grid-2">
          <section class="card" aria-labelledby="por-comuna">
            <h2 id="por-comuna">Leads por comuna</h2>
            <table class="breakdown">
              <caption class="sr-only">Cantidad de leads por comuna</caption>
              <thead>
                <tr><th>Comuna</th><th>Leads</th><th>Participación</th></tr>
              </thead>
              <tbody>
                <?php foreach ($kpis['por_comuna'] as $item): ?>
                  <?php $pct = $kpis['total'] > 0 ? (int) round(($item['total'] / $kpis['total']) * 100) : 0; ?>
                  <tr>
                    <td><?= e($item['comuna']) ?></td>
                    <td><?= e((string) $item['total']) ?></td>
                    <td>
                      <span class="bar" data-pct="<?= e((string) $pct) ?>"></span>
                      <span><?= e((string) $pct) ?>%</span>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </section>
          <?php if (!empty($kpis['por_origen'])): ?>
            <section class="card" aria-labelledby="por-origen">
              <h2 id="por-origen">Origen del CTA</h2>
              <table class="breakdown">
                <caption class="sr-only">Leads por origen de conversión</caption>
                <thead>
                  <tr><th>Origen</th><th>Leads</th></tr>
                </thead>
                <tbody>
                  <?php foreach ($kpis['por_origen'] as $item): ?>
                    <tr>
                      <td><?= e($item['origen']) ?></td>
                      <td><?= e((string) $item['total']) ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </section>
          <?php endif; ?>
        </div>
      <?php endif; ?>

      <form class="filters" method="get" action="/panel/" data-csrf="<?= e($token) ?>">
        <label>Comuna
          <select name="comuna">
            <option value="">Todas las mías</option>
            <?php foreach ($names as $name): ?>
              <option value="<?= e($name) ?>"<?= $filters['comuna'] === $name ? ' selected' : '' ?>><?= e($name) ?></option>
            <?php endforeach; ?>
          </select>
        </label>
        <label>Prioridad
          <select name="score">
            <option value="">Todas</option>
            <?php foreach (['ALTO', 'MEDIO', 'BAJO'] as $score): ?>
              <option value="<?= e($score) ?>"<?= $filters['score'] === $score ? ' selected' : '' ?>><?= e($score) ?></option>
            <?php endforeach; ?>
          </select>
        </label>
        <label>Estado
          <select name="estado">
            <option value="">Todos</option>
            <?php foreach (lead_catalog()['estados'] as $estado): ?>
              <option value="<?= e($estado) ?>"<?= $filters['estado'] === $estado ? ' selected' : '' ?>><?= e($estado) ?></option>
            <?php endforeach; ?>
          </select>
        </label>
        <label>Buscar
          <input type="search" name="q" value="<?= e($filters['q']) ?>" maxlength="80" placeholder="Nombre o WhatsApp">
        </label>
        <button class="btn btn-amber btn-small" type="submit">Filtrar</button>
        <?php if ($isAdmin): ?>
          <a class="btn btn-ghost btn-small" href="<?= e($export) ?>">Exportar CSV</a>
        <?php endif; ?>
      </form>

      <p class="note" id="empty-leads"<?= $leads === [] ? '' : ' hidden' ?>>Todavía no hay leads con ese filtro.</p>
      <p class="scroll-hint" id="scroll-hint"<?= $leads === [] ? ' hidden' : '' ?>>En el celular, desliza la tabla hacia el lado para ver estado y notas.</p>
      <div class="table-wrap" id="table-wrap"<?= $leads === [] ? ' hidden' : '' ?>>
          <table class="leads">
            <caption class="sr-only">Leads de tu cobertura</caption>
            <thead>
              <tr>
                <th>Fecha</th>
                <th>Comuna</th>
                <th>Proyecto</th>
                <th>Prioridad</th>
                <th>Contacto</th>
                <th>Seguimiento</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($leads as $lead): ?>
                <?php
                  $digits = phone_digits((string) $lead['whatsapp']);
                  $waText = rawurlencode(
                      'Hola ' . $lead['nombre'] . ', te contacto de Panel Solar Norte por tu proyecto en '
                      . $lead['comuna'] . ' (' . $lead['tipo_proyecto'] . ').'
                  );
                  $estadoClass = 'tag-' . strtolower((string) $lead['estado']);
                  $scoreClass = 'tag-' . strtolower((string) $lead['lead_score']);
                ?>
                <tr class="estado-<?= e(strtolower((string) $lead['estado'])) ?>">
                  <td><?= e((new DateTimeImmutable((string) $lead['created_at']))->format('d-m-Y H:i')) ?></td>
                  <td><?= e((string) $lead['comuna']) ?></td>
                  <td>
                    <?= e((string) $lead['tipo_proyecto']) ?><br>
                    <?= e((string) $lead['gasto_luz']) ?><br>
                    <?= e((string) $lead['plazo']) ?>
                    <?php if (!empty($lead['kwp_estimado'])): ?>
                      <br><span class="cell-url"><?= e((string) $lead['kwp_estimado']) ?> kWp<?= !empty($lead['ahorro_estimado']) ? ' · ' . e((string) $lead['ahorro_estimado']) : '' ?></span>
                    <?php endif; ?>
                    <?php if (!empty($lead['origen_cta'])): ?>
                      <br><span class="tag tag-medio"><?= e((string) $lead['origen_cta']) ?></span>
                    <?php endif; ?>
                    <?php if (!empty($lead['source_url'])): ?>
                      <br><span class="cell-url"><?= e((string) $lead['source_url']) ?></span>
                    <?php endif; ?>
                  </td>
                  <td><span class="tag <?= e($scoreClass) ?>"><?= e((string) $lead['lead_score']) ?></span></td>
                  <td>
                    <strong><?= e((string) $lead['nombre']) ?></strong><br>
                    <?= e((string) $lead['whatsapp']) ?><br>
                    <?php if ($digits !== ''): ?>
                      <a href="https://wa.me/<?= e($digits) ?>?text=<?= e($waText) ?>" target="_blank" rel="noopener">Abrir WhatsApp</a>
                    <?php endif; ?>
                    <?php if (!empty($lead['email'])): ?><br><?= e((string) $lead['email']) ?><?php endif; ?>
                  </td>
                  <td>
                    <form class="lead-form" method="post" action="/panel/">
                      <input type="hidden" name="action" value="update">
                      <input type="hidden" name="csrf" value="<?= e($token) ?>">
                      <input type="hidden" name="id" value="<?= e((string) $lead['id']) ?>">
                      <input type="hidden" name="back" value="<?= e($back) ?>">
                      <label class="sr-only" for="estado-<?= e((string) $lead['id']) ?>">Estado del lead <?= e((string) $lead['nombre']) ?></label>
                      <select id="estado-<?= e((string) $lead['id']) ?>" name="estado">
                        <?php foreach (lead_catalog()['estados'] as $estado): ?>
                          <option value="<?= e($estado) ?>"<?= $lead['estado'] === $estado ? ' selected' : '' ?>><?= e($estado) ?></option>
                        <?php endforeach; ?>
                      </select>
                      <label class="sr-only" for="notas-<?= e((string) $lead['id']) ?>">Notas de <?= e((string) $lead['nombre']) ?></label>
                      <textarea id="notas-<?= e((string) $lead['id']) ?>" name="notas" rows="2" maxlength="1000" placeholder="Nota interna"><?= e((string) ($lead['notas'] ?? '')) ?></textarea>
                      <button class="btn btn-amber btn-small" type="submit">Guardar</button>
                      <span class="save-state" role="status"></span>
                    </form>
                    <span class="sr-only <?= e($estadoClass) ?>"></span>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
    <?php endif; ?>
  </div>
</main>
<?php require dirname(__DIR__) . '/includes/footer.php'; ?>

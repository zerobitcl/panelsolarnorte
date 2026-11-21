<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/functions.php';

$slug = $_GET['slug'] ?? '';
if (!is_string($slug)) {
    $slug = '';
}
$slug = strtolower($slug);
$todas = comunas();

if (!isset($todas[$slug])) {
    http_response_code(404);
    require __DIR__ . '/404.php';
    exit;
}

$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
if (is_string($uri) && basename($uri) === 'comuna.php') {
    header('Location: ' . $todas[$slug]['path'], true, 301);
    exit;
}

$comuna = $todas[$slug];
$esSatelite = ($comuna['nivel'] ?? '') === 'satelite';
$madreSlug = (string) ($comuna['madre'] ?? '');
$madre = $madreSlug !== '' && isset($todas[$madreSlug]) ? $todas[$madreSlug] : null;
$services = [];
foreach ($comuna['servicios'] as $servicio) {
    $services[] = is_array($servicio) ? (string) ($servicio['titulo'] ?? '') : (string) $servicio;
}
$services = array_values(array_filter($services));
$schemaOpts = [
    'path' => $comuna['path'],
    'description' => $comuna['description'],
    'locality' => $comuna['nombre'],
    'region' => $comuna['region'],
    'areas' => [
        ['type' => 'City', 'name' => $comuna['nombre']],
    ],
    'services' => $services,
    'faqs' => faq_plain($comuna['faqs']),
    'crumbs' => true,
    'crumb_current' => 'Paneles Solares ' . $comuna['nombre'],
];
if ($esSatelite && $madre) {
    $schemaOpts['crumb_mid'] = [
        'name' => 'Paneles Solares ' . $madre['nombre'],
        'path' => $madre['path'],
    ];
}
$page = [
    'title' => $comuna['title'],
    'description' => $comuna['description'],
    'path' => $comuna['path'],
    'slug' => $slug,
    'dock' => true,
    'calc' => true,
    'page_tipo' => 'comuna',
    'schema' => schema_graph($schemaOpts),
];
$preselect = $esSatelite && $madreSlug !== '' ? $madreSlug : $slug;
if ($esSatelite) {
    $preselect = $slug;
}

require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
$hijos = satelites_de($esSatelite ? $madreSlug : $slug);
?>
<main id="contenido">
  <article>
    <header class="hero">
      <div class="wrap">
        <nav class="crumbs" aria-label="Miga de pan">
          <ol>
            <li><a href="/">Inicio</a></li>
            <?php if ($esSatelite && $madre): ?>
              <li><a href="<?= e($madre['path']) ?>">Paneles Solares <?= e($madre['nombre']) ?></a></li>
            <?php endif; ?>
            <li aria-current="page">Paneles Solares <?= e($comuna['nombre']) ?></li>
          </ol>
        </nav>
        <div class="hero-grid">
          <div class="hero-copy">
            <p class="eyebrow"><?= e($comuna['eyebrow']) ?></p>
            <h1><?= highlight_h1((string) $comuna['h1']) ?></h1>
            <?php
              $leadRaw = str_replace(['\\n\\n', '\\n'], ["\n\n", "\n"], (string) $comuna['lead']);
              foreach (preg_split("/\n\n+/", $leadRaw) ?: [] as $p):
                $p = trim($p);
                if ($p === '') { continue; }
            ?>
              <p class="lead"><?= e($p) ?></p>
            <?php endforeach; ?>
            <ul class="badges">
              <li>Cobertura <?= e($comuna['nombre']) ?></li>
              <li>Instalador autorizado SEC</li>
              <li><?= e($comuna['region_larga']) ?></li>
            </ul>
            <p class="hero-links"><a class="btn btn-ghost btn-small" href="#calculadora">Calcular ahorro</a></p>
          </div>
          <?php require __DIR__ . '/includes/precalificador.php'; ?>
        </div>
      </div>
    </header>

    <?php require __DIR__ . '/includes/calculadora.php'; ?>
    <?php require __DIR__ . '/includes/confianza.php'; ?>

    <section class="section" aria-labelledby="contexto-titulo">
      <div class="wrap">
        <p class="eyebrow">Contexto local</p>
        <h2 id="contexto-titulo"><?= e($comuna['contexto_titulo']) ?></h2>
        <div class="grid-3">
          <?php foreach ($comuna['dolores'] as $dolor): ?>
            <article class="card">
              <h3><?= e(is_array($dolor) ? $dolor['titulo'] : 'Contexto') ?></h3>
              <p><?= e(is_array($dolor) ? $dolor['texto'] : (string) $dolor) ?></p>
            </article>
          <?php endforeach; ?>
        </div>
        <p class="note"><?= e($comuna['nota_filtro']) ?></p>
      </div>
    </section>

    <section class="section section-alt" id="sistemas" aria-labelledby="servicios-titulo">
      <div class="wrap">
        <p class="eyebrow">Qué se instala aquí</p>
        <h2 id="servicios-titulo"><?= e($comuna['servicios_titulo']) ?></h2>
        <div class="stack">
          <?php foreach ($comuna['servicios'] as $servicio): ?>
            <article class="card card-row">
              <div>
                <h3><?= e(is_array($servicio) ? $servicio['titulo'] : 'Servicio') ?></h3>
                <p><?= e(is_array($servicio) ? $servicio['texto'] : (string) $servicio) ?></p>
              </div>
              <?php if (is_array($servicio) && !empty($servicio['puntos'])): ?>
                <ul class="ticks">
                  <?php foreach ($servicio['puntos'] as $punto): ?>
                    <li><?= e($punto) ?></li>
                  <?php endforeach; ?>
                </ul>
              <?php endif; ?>
            </article>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <section class="section" id="zonas" aria-labelledby="zonas-titulo">
      <div class="wrap">
        <p class="eyebrow">Dentro de la comuna</p>
        <h2 id="zonas-titulo"><?= e($comuna['zonas_titulo']) ?></h2>
        <div class="grid-2">
          <?php foreach ($comuna['zonas'] as $zona): ?>
            <article class="card">
              <h3><?= icon('pin') ?> <?= e(is_array($zona) ? $zona['nombre'] : 'Sector') ?></h3>
              <p><?= e(is_array($zona) ? $zona['texto'] : (string) $zona) ?></p>
            </article>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <?php if ($hijos !== [] && !$esSatelite): ?>
      <section class="section section-alt" aria-labelledby="satelites-titulo">
        <div class="wrap">
          <p class="eyebrow">Zonas cercanas</p>
          <h2 id="satelites-titulo">También evaluamos cerca de <?= e($comuna['nombre']) ?></h2>
          <div class="grid-comunas">
            <?php foreach ($hijos as $hijo): ?>
              <article class="card card-link">
                <h3><?= e($hijo['nombre']) ?></h3>
                <p><?= e($hijo['card']) ?></p>
                <a href="<?= e($hijo['path']) ?>">Paneles solares en <?= e($hijo['nombre']) ?></a>
              </article>
            <?php endforeach; ?>
          </div>
        </div>
      </section>
    <?php endif; ?>

    <section class="section<?= $hijos !== [] && !$esSatelite ? '' : ' section-alt' ?>" id="proceso" aria-labelledby="proceso-titulo">
      <div class="wrap">
        <p class="eyebrow">Secuencia real</p>
        <h2 id="proceso-titulo"><?= e($comuna['proceso_titulo']) ?></h2>
        <p class="section-lead"><?= e($comuna['proceso_intro']) ?></p>
        <ol class="steps">
          <?php foreach ($comuna['pasos'] as $paso): ?>
            <li>
              <h3><?= e($paso['titulo']) ?></h3>
              <p><?= e($paso['texto']) ?></p>
            </li>
          <?php endforeach; ?>
        </ol>
      </div>
    </section>

    <section class="section" aria-labelledby="servicios-web-titulo">
      <div class="wrap">
        <h2 id="servicios-web-titulo">Servicios y guías útiles</h2>
        <div class="grid-2">
          <?php foreach (array_slice(array_values(servicios()), 0, 4) as $srv): ?>
            <article class="card card-link">
              <h3><?= e($srv['h1']) ?></h3>
              <p><?= e($srv['card']) ?></p>
              <a href="<?= e($srv['path']) ?>">Ver servicio</a>
            </article>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <section class="section section-alt" id="preguntas" aria-labelledby="faq-titulo">
      <div class="wrap">
        <p class="eyebrow">Preguntas de <?= e($comuna['nombre']) ?></p>
        <h2 id="faq-titulo">Preguntas frecuentes sobre paneles solares en <?= e($comuna['nombre']) ?></h2>
        <div class="faq-list">
          <?php foreach ($comuna['faqs'] as $faq): ?>
            <details class="faq">
              <summary><h3><?= e($faq['q']) ?></h3></summary>
              <p><?= e($faq['a']) ?></p>
              <?php if (!empty($faq['extra'])): ?><p><?= e($faq['extra']) ?></p><?php endif; ?>
            </details>
          <?php endforeach; ?>
        </div>
        <p class="section-lead cierre-local"><?= e($comuna['cierre']) ?></p>
      </div>
    </section>

    <section class="section" aria-labelledby="otras-titulo">
      <div class="wrap">
        <h2 id="otras-titulo">También evaluamos en el resto del Norte Chico</h2>
        <div class="grid-comunas">
          <?php foreach (comunas_principales() as $otroSlug => $otro): ?>
            <?php if ($otroSlug === $slug || ($madreSlug !== '' && $otroSlug === $madreSlug && $esSatelite && false)) { /* keep all except self */ } ?>
            <?php if ($otroSlug === $slug) { continue; } ?>
            <article class="card card-link">
              <h3><?= e($otro['nombre']) ?></h3>
              <p><?= e($otro['card']) ?></p>
              <a href="<?= e($otro['path']) ?>">Paneles solares en <?= e($otro['nombre']) ?></a>
            </article>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
  </article>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>

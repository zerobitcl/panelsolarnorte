<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/functions.php';

$slug = $_GET['slug'] ?? '';
if (!is_string($slug)) {
    $slug = '';
}
$slug = strtolower($slug);
$todas = servicios();

if (!isset($todas[$slug])) {
    http_response_code(404);
    require __DIR__ . '/404.php';
    exit;
}

$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
if (is_string($uri) && basename($uri) === 'silo.php') {
    header('Location: ' . $todas[$slug]['path'], true, 301);
    exit;
}

$silo = $todas[$slug];
$services = array_column($silo['servicios'], 'titulo');
$page = [
    'title' => $silo['title'],
    'description' => $silo['description'],
    'path' => $silo['path'],
    'slug' => $slug,
    'dock' => true,
    'calc' => true,
    'page_tipo' => 'servicio',
    'schema' => schema_graph([
        'path' => $silo['path'],
        'description' => $silo['description'],
        'locality' => 'La Serena',
        'region' => 'Coquimbo',
        'areas' => [
            ['type' => 'AdministrativeArea', 'name' => 'Región de Coquimbo'],
            ['type' => 'AdministrativeArea', 'name' => 'Región de Atacama'],
        ],
        'services' => $services,
        'faqs' => faq_plain($silo['faqs']),
        'crumbs' => true,
        'crumb_current' => $silo['h1'],
        'crumb_mid' => ['name' => 'Servicios', 'path' => '/servicios'],
    ]),
];
$preselect = '';
$comuna = null;

require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>
<main id="contenido">
  <article>
    <header class="hero">
      <div class="wrap">
        <nav class="crumbs" aria-label="Miga de pan">
          <ol>
            <li><a href="/">Inicio</a></li>
            <li><a href="/servicios">Servicios</a></li>
            <li aria-current="page"><?= e($silo['h1']) ?></li>
          </ol>
        </nav>
        <div class="hero-grid">
          <div class="hero-copy">
            <p class="eyebrow"><?= e($silo['eyebrow']) ?></p>
            <h1><?= e($silo['h1']) ?></h1>
            <?php foreach (preg_split("/\n\n+/", (string) $silo['lead']) ?: [] as $p): ?>
              <p class="lead"><?= e(trim(str_replace('\n', "\n", $p))) ?></p>
            <?php endforeach; ?>
            <p class="hero-links"><a class="btn btn-ghost btn-small" href="#calculadora">Calcular ahorro</a></p>
          </div>
          <?php require __DIR__ . '/includes/precalificador.php'; ?>
        </div>
      </div>
    </header>

    <?php require __DIR__ . '/includes/calculadora.php'; ?>
    <?php require __DIR__ . '/includes/confianza.php'; ?>

    <section class="section" id="sistemas" aria-labelledby="servicios-titulo">
      <div class="wrap">
        <p class="eyebrow">Qué incluye</p>
        <h2 id="servicios-titulo">Cómo resolvemos este servicio</h2>
        <div class="stack">
          <?php foreach ($silo['servicios'] as $servicio): ?>
            <article class="card card-row">
              <div>
                <h3><?= e($servicio['titulo']) ?></h3>
                <p><?= e($servicio['texto']) ?></p>
              </div>
              <ul class="ticks">
                <?php foreach ($servicio['puntos'] as $punto): ?>
                  <li><?= e($punto) ?></li>
                <?php endforeach; ?>
              </ul>
            </article>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <section class="section section-alt" id="proceso" aria-labelledby="proceso-titulo">
      <div class="wrap">
        <p class="eyebrow">Proceso</p>
        <h2 id="proceso-titulo"><?= e($silo['proceso_titulo']) ?></h2>
        <p class="section-lead"><?= e($silo['proceso_intro']) ?></p>
        <ol class="steps">
          <?php foreach ($silo['pasos'] as $paso): ?>
            <li>
              <h3><?= e($paso['titulo']) ?></h3>
              <p><?= e($paso['texto']) ?></p>
            </li>
          <?php endforeach; ?>
        </ol>
      </div>
    </section>

    <?php if (!empty($silo['comunas_relacionadas'])): ?>
      <section class="section" aria-labelledby="comunas-rel">
        <div class="wrap">
          <h2 id="comunas-rel">Comunas donde más aplica</h2>
          <div class="grid-comunas">
            <?php foreach ($silo['comunas_relacionadas'] as $cSlug): ?>
              <?php if (!isset(comunas()[$cSlug])) { continue; } $c = comunas()[$cSlug]; ?>
              <article class="card card-link">
                <h3><?= e($c['nombre']) ?></h3>
                <p><?= e($c['card']) ?></p>
                <a href="<?= e($c['path']) ?>">Paneles solares en <?= e($c['nombre']) ?></a>
              </article>
            <?php endforeach; ?>
          </div>
        </div>
      </section>
    <?php endif; ?>

    <section class="section section-alt" id="preguntas" aria-labelledby="faq-titulo">
      <div class="wrap">
        <h2 id="faq-titulo">Preguntas frecuentes</h2>
        <div class="faq-list">
          <?php foreach ($silo['faqs'] as $faq): ?>
            <details class="faq">
              <summary><h3><?= e($faq['q']) ?></h3></summary>
              <p><?= e($faq['a']) ?></p>
              <?php if (!empty($faq['extra'])): ?><p><?= e($faq['extra']) ?></p><?php endif; ?>
            </details>
          <?php endforeach; ?>
        </div>
        <p class="section-lead cierre-local"><?= e($silo['cierre']) ?></p>
      </div>
    </section>
  </article>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>

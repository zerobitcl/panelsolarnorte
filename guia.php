<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/functions.php';

$slug = $_GET['slug'] ?? '';
if (!is_string($slug)) {
    $slug = '';
}
$slug = strtolower($slug);
$todas = guias();

if (!isset($todas[$slug])) {
    http_response_code(404);
    require __DIR__ . '/404.php';
    exit;
}

$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
if (is_string($uri) && basename($uri) === 'guia.php') {
    header('Location: ' . $todas[$slug]['path'], true, 301);
    exit;
}

$guia = $todas[$slug];
$schemaOpts = [
    'path' => $guia['path'],
    'description' => $guia['description'],
    'locality' => 'La Serena',
    'region' => 'Coquimbo',
    'areas' => [],
    'services' => [],
    'faqs' => faq_plain($guia['faqs']),
    'crumbs' => true,
    'crumb_current' => $guia['h1'],
    'crumb_mid' => ['name' => 'Guías', 'path' => '/guias'],
    'article_only' => true,
    'article' => [
        '@type' => 'Article',
        'headline' => $guia['h1'],
        'dateModified' => $guia['lastmod'] ?? '2026-11-20',
    ],
];
if (($guia['schema_type'] ?? '') === 'HowTo' && !empty($guia['how_to_steps'])) {
    $schemaOpts['howto'] = $guia['how_to_steps'];
}

$page = [
    'title' => $guia['title'],
    'description' => $guia['description'],
    'path' => $guia['path'],
    'slug' => $slug,
    'dock' => true,
    'calc' => true,
    'page_tipo' => 'guia',
    'schema' => schema_graph($schemaOpts),
];
$preselect = '';
$comuna = null;

require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>
<main id="contenido">
  <article>
    <header class="hero hero-compact">
      <div class="wrap">
        <nav class="crumbs" aria-label="Miga de pan">
          <ol>
            <li><a href="/">Inicio</a></li>
            <li><a href="/guias">Guías</a></li>
            <li aria-current="page"><?= e($guia['h1']) ?></li>
          </ol>
        </nav>
        <div class="hero-grid">
          <div class="hero-copy">
            <p class="eyebrow"><?= e($guia['eyebrow']) ?></p>
            <h1><?= e($guia['h1']) ?></h1>
            <?php foreach (preg_split("/\n\n+/", (string) $guia['lead']) ?: [] as $p): ?>
              <p class="lead"><?= e(trim(str_replace('\n', "\n", $p))) ?></p>
            <?php endforeach; ?>
          </div>
          <?php require __DIR__ . '/includes/precalificador.php'; ?>
        </div>
      </div>
    </header>

    <section class="section" aria-labelledby="contenido-guia">
      <div class="wrap prose">
        <h2 id="contenido-guia" class="sr-only">Contenido de la guía</h2>
        <?php foreach ($guia['secciones'] as $sec): ?>
          <h2><?= e($sec['h2']) ?></h2>
          <p><?= e($sec['p']) ?></p>
          <?php if (!empty($sec['lista'])): ?>
            <ul>
              <?php foreach ($sec['lista'] as $li): ?>
                <li><?= e($li) ?></li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>
        <?php endforeach; ?>
      </div>
    </section>

    <?php require __DIR__ . '/includes/calculadora.php'; ?>

    <section class="section" aria-labelledby="rel-titulo">
      <div class="wrap">
        <h2 id="rel-titulo">Sigue con una comuna o un servicio</h2>
        <div class="grid-3">
          <?php foreach ($guia['comunas_relacionadas'] ?? [] as $cSlug): ?>
            <?php if (!isset(comunas()[$cSlug])) { continue; } $c = comunas()[$cSlug]; ?>
            <article class="card card-link">
              <h3><?= e($c['nombre']) ?></h3>
              <p><?= e($c['card']) ?></p>
              <a href="<?= e($c['path']) ?>">Ver comuna</a>
            </article>
          <?php endforeach; ?>
          <?php
            $srvSlug = (string) ($guia['servicio_relacionado'] ?? '');
            if ($srvSlug !== '' && isset(servicios()[$srvSlug])):
              $srv = servicios()[$srvSlug];
          ?>
            <article class="card card-link">
              <h3><?= e($srv['h1']) ?></h3>
              <p><?= e($srv['card']) ?></p>
              <a href="<?= e($srv['path']) ?>">Ver servicio</a>
            </article>
          <?php endif; ?>
        </div>
      </div>
    </section>

    <section class="section section-alt" id="preguntas" aria-labelledby="faq-titulo">
      <div class="wrap">
        <h2 id="faq-titulo">Preguntas frecuentes</h2>
        <div class="faq-list">
          <?php foreach ($guia['faqs'] as $faq): ?>
            <details class="faq">
              <summary><h3><?= e($faq['q']) ?></h3></summary>
              <p><?= e($faq['a']) ?></p>
              <?php if (!empty($faq['extra'])): ?><p><?= e($faq['extra']) ?></p><?php endif; ?>
            </details>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
  </article>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>

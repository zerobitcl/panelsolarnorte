<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/functions.php';

$tipo = $_GET['tipo'] ?? '';
if (!is_string($tipo)) {
    $tipo = '';
}
$tipo = strtolower($tipo);

if (!in_array($tipo, ['servicios', 'guias'], true)) {
    http_response_code(404);
    require __DIR__ . '/404.php';
    exit;
}

$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
if (is_string($uri) && basename($uri) === 'hub.php') {
    header('Location: /' . $tipo, true, 301);
    exit;
}

if ($tipo === 'servicios') {
    $page = [
        'title' => 'Servicios Solares en Coquimbo y Atacama | Panel Solar Norte',
        'description' => 'Net Billing, kits off-grid para parcelas, bombeo solar agrícola y paneles para empresas en el Norte Chico. Elige el servicio según tu tipo de proyecto.',
        'path' => '/servicios',
        'slug' => 'servicios',
        'dock' => true,
        'calc' => true,
        'page_tipo' => 'hub',
        'schema' => schema_graph([
            'path' => '/servicios',
            'description' => 'Catálogo de servicios fotovoltaicos en las regiones de Coquimbo y Atacama.',
            'locality' => 'La Serena',
            'region' => 'Coquimbo',
            'areas' => [
                ['type' => 'AdministrativeArea', 'name' => 'Región de Coquimbo'],
                ['type' => 'AdministrativeArea', 'name' => 'Región de Atacama'],
            ],
            'services' => array_column(array_values(servicios()), 'h1'),
            'crumbs' => true,
            'crumb_current' => 'Servicios',
        ]),
    ];
    $preselect = '';
    $comuna = null;
    require __DIR__ . '/includes/head.php';
    require __DIR__ . '/includes/header.php';
    ?>
<main id="contenido">
  <header class="hero hero-compact">
    <div class="wrap">
      <nav class="crumbs" aria-label="Miga de pan">
        <ol>
          <li><a href="/">Inicio</a></li>
          <li aria-current="page">Servicios</li>
        </ol>
      </nav>
      <div class="hero-grid">
        <div class="hero-copy">
          <p class="eyebrow">Norte Chico</p>
          <h1>Servicios solares para casa, parcela, campo y empresa</h1>
          <p class="lead">Cuatro encargos distintos. No se cotizan igual: Net Billing con TE4, off-grid con baterías, bombeo a tranque y autoconsumo comercial diurno.</p>
        </div>
        <?php require __DIR__ . '/includes/precalificador.php'; ?>
      </div>
    </div>
  </header>
  <section class="section" aria-labelledby="lista-servicios">
    <div class="wrap">
      <h2 id="lista-servicios" class="sr-only">Lista de servicios</h2>
      <div class="grid-2">
        <?php foreach (servicios() as $item): ?>
          <article class="card card-link">
            <h2 style="font-size:1.2rem"><?= e($item['h1']) ?></h2>
            <p><?= e($item['card']) ?></p>
            <a href="<?= e($item['path']) ?>">Ver servicio</a>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
  <?php require __DIR__ . '/includes/calculadora.php'; ?>
</main>
    <?php
    require __DIR__ . '/includes/footer.php';
    exit;
}

$page = [
    'title' => 'Guías Solares del Norte Chico | Panel Solar Norte',
    'description' => 'Guías prácticas: cuánto cuesta instalar, trámite TE4, on-grid vs off-grid, paneles según boleta y mantención en el desierto.',
    'path' => '/guias',
    'slug' => 'guias',
    'dock' => true,
    'calc' => true,
    'page_tipo' => 'hub',
    'schema' => schema_graph([
        'path' => '/guias',
        'description' => 'Guías informativas sobre paneles solares en Coquimbo y Atacama.',
        'locality' => 'La Serena',
        'region' => 'Coquimbo',
        'areas' => [
            ['type' => 'AdministrativeArea', 'name' => 'Región de Coquimbo'],
            ['type' => 'AdministrativeArea', 'name' => 'Región de Atacama'],
        ],
        'services' => ['Evaluación de proyectos solares'],
        'crumbs' => true,
        'crumb_current' => 'Guías',
        'article_only' => true,
        'article' => [
            '@type' => 'CollectionPage',
            'headline' => 'Guías solares del Norte Chico',
            'dateModified' => '2026-11-20',
        ],
    ]),
];
$preselect = '';
$comuna = null;
require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>
<main id="contenido">
  <header class="hero hero-compact">
    <div class="wrap">
      <nav class="crumbs" aria-label="Miga de pan">
        <ol>
          <li><a href="/">Inicio</a></li>
          <li aria-current="page">Guías</li>
        </ol>
      </nav>
      <div class="hero-grid">
        <div class="hero-copy">
          <p class="eyebrow">Contenido útil</p>
          <h1>Guías solares del Norte Chico</h1>
          <p class="lead">Respuestas directas antes de cotizar: costos, TE4, on-grid vs off-grid, tamaño según boleta y mantención con polvo y calor.</p>
        </div>
        <?php require __DIR__ . '/includes/precalificador.php'; ?>
      </div>
    </div>
  </header>
  <section class="section" aria-labelledby="lista-guias">
    <div class="wrap">
      <h2 id="lista-guias" class="sr-only">Lista de guías</h2>
      <div class="grid-comunas">
        <?php foreach (guias() as $item): ?>
          <article class="card card-link">
            <h2 style="font-size:1.15rem"><?= e($item['h1']) ?></h2>
            <p><?= e($item['description']) ?></p>
            <a href="<?= e($item['path']) ?>">Leer guía</a>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
  <?php require __DIR__ . '/includes/calculadora.php'; ?>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>

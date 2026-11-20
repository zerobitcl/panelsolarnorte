<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/functions.php';

http_response_code(404);
$page = [
    'title' => 'Página no encontrada | Panel Solar Norte',
    'description' => 'Esa dirección no existe. Revisa las comunas de cobertura en Coquimbo y Atacama.',
    'path' => '/404',
    'robots' => 'noindex, follow',
    'error404' => true,
    'slug' => '',
];
require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>
<main id="contenido" class="section">
  <div class="wrap prose">
    <p class="eyebrow">404</p>
    <h1>No encontramos esa página</h1>
    <p>La dirección no corresponde a una comuna de cobertura. Puedes volver al inicio o entrar directo a una ciudad.</p>
    <ul class="link-list">
      <li><a href="/">Inicio del Norte Chico</a></li>
      <li><a href="/servicios">Servicios</a></li>
      <li><a href="/guias">Guías</a></li>
      <?php foreach (comunas_principales() as $item): ?>
        <li><a href="<?= e($item['path']) ?>">Paneles solares en <?= e($item['nombre']) ?></a></li>
      <?php endforeach; ?>
    </ul>
  </div>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>

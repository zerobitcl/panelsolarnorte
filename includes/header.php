<?php
declare(strict_types=1);
/** @var array $page */
$current = (string) ($page['slug'] ?? '');
$cta = (!empty($page['panel']) || !empty($page['error404'])) ? '/#precalificador' : '#precalificador';
?>
<a class="skip" href="#contenido">Saltar al contenido</a>
<header class="site-header">
  <div class="wrap header-bar">
    <a class="logo" href="/" aria-label="Panel Solar Norte, inicio">
      <img class="logo-mark" src="/assets/img/logo-icon.jpg" width="48" height="48" alt="" decoding="async">
      <span>
        <strong>Panel Solar Norte</strong>
        <small>Energía del Norte Chico</small>
      </span>
    </a>
    <button class="nav-toggle" type="button" aria-expanded="false" aria-controls="nav-principal">
      <span class="sr-only">Abrir menú</span>
      <svg viewBox="0 0 24 24" width="22" height="22" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.8">
        <path d="M4 7h16M4 12h16M4 17h16"/>
      </svg>
    </button>
    <nav class="nav" id="nav-principal" aria-label="Principal">
      <?php foreach (comunas_nav() as $slug => $item): ?>
        <a href="<?= e($item['path']) ?>"<?= $current === $slug ? ' aria-current="page"' : '' ?>><?= e($item['nombre']) ?></a>
      <?php endforeach; ?>
      <a href="/servicios"<?= $current === 'servicios' ? ' aria-current="page"' : '' ?>>Servicios</a>
      <a href="/guias"<?= $current === 'guias' ? ' aria-current="page"' : '' ?>>Guías</a>
      <a class="btn btn-amber btn-small" href="<?= e($cta) ?>">Evaluar proyecto</a>
    </nav>
  </div>
</header>

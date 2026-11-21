<?php
declare(strict_types=1);
/** @var array $page */
$year = date('Y');
?>
<footer class="site-footer">
  <div class="wrap footer-grid footer-grid-4">
    <div>
      <p class="footer-brand">
        <img src="/assets/img/logo-full.jpg" width="220" height="80" alt="Panel Solar Norte — Energía del Norte Chico" decoding="async" loading="lazy">
      </p>
      <p>Evaluación de proyectos fotovoltaicos en las regiones de Coquimbo y Atacama. La conexión on-grid la declara un instalador eléctrico autorizado ante la SEC (formulario TE4) y la habilita la distribuidora.</p>
    </div>
    <div>
      <p class="footer-title">Comunas</p>
      <ul>
        <?php foreach (comunas_nav() as $item): ?>
          <li><a href="<?= e($item['path']) ?>">Paneles solares en <?= e($item['nombre']) ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <div>
      <p class="footer-title">Servicios</p>
      <ul>
        <?php foreach (servicios() as $item): ?>
          <li><a href="<?= e($item['path']) ?>"><?= e($item['card']) ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <div>
      <p class="footer-title">Guías</p>
      <ul>
        <?php foreach (array_slice(array_values(guias()), 0, 4) as $item): ?>
          <li><a href="<?= e($item['path']) ?>"><?= e($item['h1']) ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
  <div class="wrap footer-base">
    <p>© <?= e($year) ?> Panel Solar Norte. La Serena, Coquimbo, Ovalle, Copiapó, Vallenar y comunas satélite del Norte Chico.</p>
    <p class="fine"><a href="/instaladores">¿Eres instalador SEC? Postula a una zona exclusiva</a></p>
  </div>
</footer>
<?php if (!empty($page['dock'])): ?>
  <div class="dock">
    <a class="btn btn-amber" href="#precalificador" data-origen-set="dock">Evaluar mi proyecto</a>
  </div>
<?php endif; ?>
<?php if (!empty($page['panel'])): ?>
  <script src="/assets/js/panel.js?v=4" defer></script>
<?php else: ?>
  <script src="/assets/js/app.js?v=4" defer></script>
  <?php if (!empty($page['calc'])): ?>
    <script src="/assets/js/calc.js?v=4" defer></script>
  <?php endif; ?>
<?php endif; ?>
</body>
</html>

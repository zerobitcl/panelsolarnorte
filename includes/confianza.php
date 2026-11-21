<?php
declare(strict_types=1);
/** @var array|null $comuna */
$comuna = $comuna ?? null;
$nombreZona = is_array($comuna) ? (string) $comuna['nombre'] : 'el Norte Chico';
$casos = is_array($comuna) ? ($comuna['casos'] ?? []) : [];
if ($casos === []) {
    foreach (comunas_principales() as $item) {
        foreach ($item['casos'] ?? [] as $caso) {
            $casos[] = $caso + ['zona' => $item['nombre']];
            if (count($casos) >= 3) {
                break 2;
            }
        }
    }
}
$testimonios = is_array($comuna) ? ($comuna['testimonios'] ?? []) : [];
?>
<section class="section" id="confianza" aria-labelledby="confianza-titulo">
  <div class="wrap">
    <p class="eyebrow">Criterio técnico, no promesa vacía</p>
    <h2 id="confianza-titulo">Por qué confiar en una evaluación seria en <?= e($nombreZona) ?></h2>
    <p class="urgency-bar" role="status">Visitas técnicas en <?= e($nombreZona) ?> esta semana · respuesta por WhatsApp, sin llamadas en frío</p>

    <div class="grid-4 trust-strip">
      <article class="card compact">
        <span class="card-icon"><?= icon('shield') ?></span>
        <h3>Módulos 25 años</h3>
        <p>Garantía de producción del módulo según fabricante. No confundir con la vida útil del resto del sistema.</p>
      </article>
      <article class="card compact">
        <span class="card-icon"><?= icon('bolt') ?></span>
        <h3>Inversor 10 años</h3>
        <p>El inversor es la pieza que más se cambia. Cotizamos marcas con respaldo y acceso a servicio.</p>
      </article>
      <article class="card compact">
        <span class="card-icon"><?= icon('check') ?></span>
        <h3>Mano de obra por escrito</h3>
        <p>La instalación y las correcciones de obra quedan en la propuesta, no en un WhatsApp perdido.</p>
      </article>
      <article class="card compact">
        <span class="card-icon"><?= icon('grid') ?></span>
        <h3>TE4 incluido (on-grid)</h3>
        <p>Si hay inyección a la red, el trámite SEC lo declara un instalador autorizado. Off-grid no lo necesita.</p>
      </article>
    </div>

    <?php if ($casos !== []): ?>
      <h3 class="subhead">Proyectos tipo en la zona</h3>
      <p class="fine">Casos de referencia para dimensionar expectativas. No son testimonios personales inventados.</p>
      <div class="grid-3">
        <?php foreach (array_slice($casos, 0, 3) as $caso): ?>
          <article class="card">
            <p class="zone-region">Proyecto tipo<?= !empty($caso['zona']) ? ' · ' . e((string) $caso['zona']) : '' ?></p>
            <h3><?= e((string) $caso['titulo']) ?></h3>
            <p><?= e((string) $caso['texto']) ?></p>
            <p class="result-line"><?= e((string) ($caso['resultado'] ?? '')) ?></p>
          </article>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <?php if ($testimonios !== []): ?>
      <h3 class="subhead">Lo que dicen clientes</h3>
      <div class="grid-2">
        <?php foreach ($testimonios as $t): ?>
          <blockquote class="card quote">
            <p><?= e((string) $t['texto']) ?></p>
            <footer>— <?= e((string) $t['nombre']) ?><?= !empty($t['lugar']) ? ', ' . e((string) $t['lugar']) : '' ?></footer>
          </blockquote>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <div class="grid-2 trust-split">
      <article class="card">
        <h3>Qué revisamos en la visita</h3>
        <ul class="ticks">
          <li>Cubierta, orientación y sombras reales (no solo Google Maps).</li>
          <li>Tablero, empalme y espacio del inversor o baterías.</li>
          <li>Corrosión, polvo, calor de techo o acceso de camioneta.</li>
          <li>Lista de cargas nocturnas si el proyecto es off-grid o bombeo.</li>
        </ul>
      </article>
      <article class="card">
        <h3>Por qué no te vamos a vender lo que no necesitas</h3>
        <p>Si la boleta es baja, el techo no es tuyo o el riego solo puede hacerse de noche, la evaluación lo dice. Prefieres un “no conviene” ahora a un sistema que no se paga.</p>
        <ul class="ticks">
          <li>Filtramos curiosos sin superficie ni presupuesto.</li>
          <li>Separamos casa, parcela y pozo: no se cotizan igual.</li>
          <li>El Net Billing no borra el cargo fijo ni el consumo nocturno.</li>
        </ul>
      </article>
    </div>

    <div class="photo-systems">
      <figure class="photo-card">
        <img src="/assets/img/casa-paneles.jpg" width="640" height="400" alt="Casa con paneles solares on-grid en techo" loading="lazy" decoding="async">
        <figcaption>On-grid en techo</figcaption>
      </figure>
      <figure class="photo-card">
        <img src="/assets/img/sistema-offgrid.jpg" width="640" height="400" alt="Sistema off-grid con batería e inversor" loading="lazy" decoding="async">
        <figcaption>Off-grid con batería</figcaption>
      </figure>
      <figure class="photo-card">
        <img src="/assets/img/instalacion-techo.jpg" width="640" height="400" alt="Cuadrilla instalando paneles solares en techo" loading="lazy" decoding="async">
        <figcaption>Instalación en obra</figcaption>
      </figure>
    </div>
  </div>
</section>

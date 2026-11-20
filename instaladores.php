<?php
declare(strict_types=1);

require __DIR__ . '/includes/functions.php';

$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
if (is_string($uri) && basename($uri) === 'instaladores.php') {
    header('Location: /instaladores', true, 301);
    exit;
}

$plazas = site_config()['plazas'] ?? [];
$vacantes = plazas_disponibles();
$adminWa = preg_replace('/\D+/', '', (string) site_config()['whatsapp']) ?: '';

$page = [
    'title' => 'Arriendo de Zonas Exclusivas | Instaladores SEC Norte Chico',
    'description' => 'Arrienda una plaza exclusiva de leads solares precalificados en Coquimbo o Atacama. Un solo instalador autorizado SEC por zona, sin competencia interna.',
    'path' => '/instaladores',
    'slug' => 'instaladores',
    'dock' => false,
    'calc' => false,
    'page_tipo' => 'instaladores',
    'robots' => 'index, follow',
    'schema' => schema_graph([
        'path' => '/instaladores',
        'description' => 'Modelo Rank & Rent: plazas exclusivas de leads solares precalificados para instaladores eléctricos autorizados SEC en el Norte Chico.',
        'locality' => 'La Serena',
        'region' => 'Coquimbo',
        'areas' => [
            ['type' => 'AdministrativeArea', 'name' => 'Región de Coquimbo'],
            ['type' => 'AdministrativeArea', 'name' => 'Región de Atacama'],
        ],
        'services' => ['Arriendo exclusivo de leads solares por zona'],
        'crumbs' => true,
        'crumb_current' => 'Instaladores',
        'faqs' => [
            [
                'q' => '¿Qué es una plaza exclusiva?',
                'a' => 'Una zona geográfica (Elqui, Limarí o Atacama) arrendada a un solo instalador autorizado SEC. Todos los leads de esas comunas y satélites llegan solo a ti.',
            ],
            [
                'q' => '¿Cómo llegan los leads?',
                'a' => 'Precalificados por comuna, tipo de proyecto, gasto de luz y plazo. Incluyen WhatsApp del interesado y, si usó la calculadora, kWp estimado.',
            ],
            [
                'q' => '¿Hay competencia entre instaladores en la misma zona?',
                'a' => 'No. El modelo es exclusividad: un arrendatario por plaza. No se venden los mismos leads a cinco empresas.',
            ],
        ],
    ]),
];

require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>
<main id="contenido">
  <header class="hero hero-compact">
    <div class="wrap">
      <nav class="crumbs" aria-label="Miga de pan">
        <ol>
          <li><a href="/">Inicio</a></li>
          <li aria-current="page">Instaladores</li>
        </ol>
      </nav>
      <div class="hero-copy" style="max-width:72ch">
        <p class="eyebrow">Rank &amp; Rent · Norte Chico</p>
        <h1>Arrienda una zona exclusiva de leads solares</h1>
        <p class="lead">Panel Solar Norte captura tráfico orgánico de Coquimbo y Atacama y entrega proyectos precalificados a un solo instalador autorizado SEC por plaza. Sin guerra de precios entre cinco empresas por el mismo contacto.</p>
      </div>
    </div>
  </header>

  <section class="section" aria-labelledby="modelo-titulo">
    <div class="wrap">
      <p class="eyebrow">Cómo funciona</p>
      <h2 id="modelo-titulo">Exclusividad por plaza, no por lead suelto</h2>
      <div class="grid-3">
        <article class="card">
          <h3>1. Tráfico orgánico propio</h3>
          <p>Páginas de comuna, satélites, servicios y guías rankean para búsquedas locales. El lead llega ya filtrado por comuna, uso y gasto.</p>
        </article>
        <article class="card">
          <h3>2. Un arrendatario por zona</h3>
          <p>Elqui/Costa, Limarí o Atacama. Mientras pagas la plaza, WhatsApp y alertas van solo a tu número. Nadie más en tu territorio.</p>
        </article>
        <article class="card">
          <h3>3. Panel con valor del mes</h3>
          <p>Ves leads recibidos, prioridad ALTA y kWp estimados acumulados. Sirve para justificar la renovación con números, no con promesas.</p>
        </article>
      </div>
    </div>
  </section>

  <section class="section section-alt" aria-labelledby="plazas-titulo">
    <div class="wrap">
      <p class="eyebrow">Plazas</p>
      <h2 id="plazas-titulo">Cobertura actual</h2>
      <div class="grid-3">
        <?php foreach ($plazas as $id => $plaza): ?>
          <?php
            $activa = ($plaza['estado'] ?? '') === 'activa' && trim((string) ($plaza['whatsapp'] ?? '')) !== '';
            $madres = $plaza['comunas_madre'] ?? [];
            $nombres = [];
            foreach ($madres as $m) {
                if (isset(comunas()[$m])) {
                    $nombres[] = comunas()[$m]['nombre'];
                }
            }
          ?>
          <article class="card">
            <p class="zone-region"><?= $activa ? 'Arrendada' : 'Disponible' ?></p>
            <h3><?= e((string) ($plaza['nombre'] ?? $id)) ?></h3>
            <p>Comunas madre: <?= e(implode(', ', $nombres)) ?>. Incluye satélites de esas comunas.</p>
            <?php if ($activa): ?>
              <p class="fine">Plaza ocupada. Puedes postular a lista de espera.</p>
            <?php else: ?>
              <p class="result-line">Plaza vacante · leads van a administración hasta arriendo.</p>
            <?php endif; ?>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section class="section" aria-labelledby="requisitos-titulo">
    <div class="wrap prose">
      <p class="eyebrow">Requisitos</p>
      <h2 id="requisitos-titulo">Qué pedimos para arrendar</h2>
      <ul>
        <li>Instalador eléctrico autorizado SEC (o empresa con instalador a cargo del TE4).</li>
        <li>Cobertura real en la plaza (visita técnica en la zona, no solo cotización remota).</li>
        <li>WhatsApp de respuesta rápida: el lead espera contacto, no un CRM frío.</li>
        <li>Compromiso de exclusividad: no revender ni compartir los leads de la plaza.</li>
      </ul>
      <p>El arriendo es mensual fijo por zona. No cobramos comisión por cierre: el incentivo es atender bien para renovar.</p>
    </div>
  </section>

  <section class="cta-band" aria-labelledby="postula-titulo">
    <div class="wrap">
      <h2 id="postula-titulo"><?= $vacantes !== [] ? 'Hay plazas disponibles' : 'Postula a lista de espera' ?></h2>
      <p>Escríbenos por WhatsApp indicando tu comuna de operación, cobertura SEC y la plaza que te interesa. Respondemos con condiciones y disponibilidad.</p>
      <a class="btn btn-amber" href="https://wa.me/<?= e($adminWa) ?>?text=<?= e(rawurlencode('Hola, soy instalador SEC y quiero información para arrendar una plaza en Panel Solar Norte.')) ?>" target="_blank" rel="noopener">Escribir por WhatsApp</a>
    </div>
  </section>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>

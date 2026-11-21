<?php
declare(strict_types=1);

require __DIR__ . '/includes/functions.php';

if (PHP_SAPI !== 'cli' && PHP_SAPI !== 'cli-server') {
    $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    if (is_string($uri) && basename($uri) === 'index.php') {
        header('Location: /', true, 301);
        exit;
    }
}

$faqs = [
    [
        'q' => '¿Qué es el Net Billing en Coquimbo y Atacama?',
        'a' => 'Es el régimen de la Ley 20.571, ampliado por la Ley 21.118, que permite instalar hasta 300 kW, consumir primero lo que produces e inyectar el excedente a la red de CGE.',
        'extra' => 'El excedente se valoriza y se descuenta en la boleta. No es un peso a peso de toda la tarifa ni elimina el cargo fijo. El diseño se hace sobre tu consumo diurno, no sobre el máximo de paneles que caben.',
    ],
    [
        'q' => '¿En qué se diferencian on-grid, off-grid y bombeo solar?',
        'a' => 'On-grid es una casa o pyme con empalme: ahorra boleta e inyecta. Off-grid es una parcela sin red, con baterías. Bombeo solar mueve agua de un pozo o canal, de día, hacia un tranque.',
        'extra' => 'Mezclar los tres en un solo equipo suele dejar la noche corta o el riego caro. Por eso el formulario obliga a elegir el uso principal.',
    ],
    [
        'q' => '¿Qué es el trámite SEC TE4?',
        'a' => 'Es la declaración de la instalación de generación ante la SEC. La firma un instalador eléctrico autorizado, no el propietario.',
        'extra' => 'Después CGE cambia el medidor a bidireccional. El plazo de esa etapa no lo fija la cuadrilla. Un sistema off-grid o un bombeo sin inyección no sigue ese trámite de conexión.',
    ],
    [
        'q' => '¿En qué comunas evalúan proyectos?',
        'a' => 'En La Serena, Coquimbo, Ovalle, Copiapó y Vallenar, más satélites: Vicuña, Tongoy, Monte Patria, Caldera, Tierra Amarilla, Huasco y Freirina. Otras comunas de la IV y III Región se pueden dejar en el formulario.',
        'extra' => 'Cada página explica el encargo local: salitre en la costa, pozos en el Limarí y el Huasco, calor y polvo en Atacama.',
    ],
    [
        'q' => '¿La evaluación compromete a comprar?',
        'a' => 'No. Sirve para filtrar comuna, tipo de proyecto, gasto y plazo, y para que el instalador de esa zona te escriba por WhatsApp si el caso da para una visita.',
        'extra' => 'Si la boleta es muy baja y solo estás mirando precios, el lead queda con prioridad baja. Igual puedes enviar el formulario.',
    ],
];

$page = [
    'title' => 'Paneles Solares en Coquimbo y Atacama | Panel Solar Norte',
    'description' => 'Instalación de paneles solares en las regiones de Coquimbo y Atacama: on-grid con Net Billing y TE4, off-grid para parcelas y bombeo solar agrícola en el Norte Chico.',
    'path' => '/',
    'slug' => '',
    'dock' => true,
    'calc' => true,
    'page_tipo' => 'home',
    'schema' => schema_graph([
        'path' => '/',
        'description' => 'Evaluación e instalación de sistemas fotovoltaicos on-grid, off-grid y de bombeo en las regiones de Coquimbo y Atacama, Chile.',
        'locality' => 'La Serena',
        'region' => 'Coquimbo',
        'areas' => [
            ['type' => 'AdministrativeArea', 'name' => 'Región de Coquimbo'],
            ['type' => 'AdministrativeArea', 'name' => 'Región de Atacama'],
        ],
        'services' => [
            'Sistemas solares on-grid con Net Billing',
            'Kits off-grid para parcelas sin empalme',
            'Bombeo solar agrícola',
        ],
        'faqs' => faq_plain($faqs),
        'crumbs' => false,
    ]),
];
$preselect = '';

require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>
<main id="contenido">
  <header class="hero hero-photo">
    <div class="hero-media" aria-hidden="true">
      <img src="/assets/img/instalacion-techo.jpg" width="1600" height="900" alt="" fetchpriority="high" decoding="async">
    </div>
    <div class="wrap hero-grid">
      <div class="hero-copy">
        <p class="eyebrow">Norte Chico · Coquimbo y Atacama</p>
        <h1>Instalación de <span class="h1-accent">Paneles Solares</span> en las Regiones de Coquimbo y Atacama</h1>
        <p class="lead">Diseñamos tres encargos distintos: bajar la boleta con un sistema on-grid y Ley de Net Billing, electrificar una parcela que todavía no tiene empalme, o mover agua de un pozo con bombeo solar. La visita y el trámite SEC TE4 los hace un instalador eléctrico autorizado de la zona.</p>
        <ul class="badges">
          <li>Trámite SEC TE4</li>
          <li>Ley Net Billing</li>
          <li>IV y III Región</li>
        </ul>
        <ul class="checks">
          <li>Coquimbo: La Serena, Coquimbo, Ovalle, Vicuña, Tongoy y Monte Patria.</li>
          <li>Atacama: Copiapó, Vallenar, Caldera, Tierra Amarilla, Huasco y Freirina.</li>
          <li>Si la cuenta es baja o no hay techo propio, la evaluación lo dice.</li>
        </ul>
      </div>
      <?php require __DIR__ . '/includes/precalificador.php'; ?>
    </div>
  </header>

  <?php $comuna = null; require __DIR__ . '/includes/calculadora.php'; ?>
  <?php require __DIR__ . '/includes/confianza.php'; ?>

  <section class="section" id="sistemas" aria-labelledby="sistemas-titulo">
    <div class="wrap">
      <p class="eyebrow">Tres sistemas, tres presupuestos</p>
      <h2 id="sistemas-titulo">On-grid, off-grid y bombeo solar</h2>
      <p class="section-lead">No se parte por la cantidad de paneles. Se parte por si existe medidor, si el consumo es de día y si el problema real es la boleta, la noche sin red o el diésel del riego.</p>
      <div class="grid-3">
        <article class="card card-media">
          <img src="/assets/img/casa-paneles.jpg" width="480" height="300" alt="Casa con sistema solar on-grid" loading="lazy" decoding="async">
          <h3>On-grid: ahorro de boleta e inyección</h3>
          <p>Casa o pyme con empalme CGE. De día consumes lo que produces. El excedente se inyecta y se descuenta en la boleta bajo la Ley 20.571, ampliada por la Ley 21.118, hasta 300 kW. El instalador autorizado ingresa el TE4 a la SEC y la distribuidora cambia el medidor a bidireccional.</p>
          <p>No borra el cargo fijo ni lo que enciendes de noche. Por eso una casa vacía hasta las 21:00 rinde menos que un local o un aire acondicionado diurno.</p>
        </article>
        <article class="card card-media">
          <img src="/assets/img/sistema-offgrid.jpg" width="480" height="300" alt="Batería e inversor de sistema off-grid" loading="lazy" decoding="async">
          <h3>Off-grid: parcela sin empalme</h3>
          <p>Cuando la factibilidad de red sale más cara que el uso del sitio, el sistema lleva baterías e inversor cargador. No se conecta a CGE y no corresponde venderlo como Net Billing.</p>
          <p>La batería sale de una lista de cargas nocturnas. Refrigerador, luces y bomba chica es un proyecto. Aire acondicionado toda la noche es otro, y mucho más caro.</p>
        </article>
        <article class="card card-media">
          <img src="/assets/img/instalacion-techo.jpg" width="480" height="300" alt="Instalación de paneles en techo de campo" loading="lazy" decoding="async">
          <h3>Bombeo e instalación en terreno</h3>
          <p>En el Limarí y en el Huasco el encargo suele ser un pozo, no un techo. Si el riego puede correr de día, el arreglo alimenta la bomba y el tranque hace de reserva. La batería solo entra si hay turno nocturno o una casa en el mismo predio.</p>
          <p>Sin profundidad, caudal y desnivel no hay potencia seria. Esos datos valen más que la marca del módulo.</p>
        </article>
      </div>
    </div>
  </section>

  <section class="section section-alt" id="tramite" aria-labelledby="tramite-titulo">
    <div class="wrap prose">
      <p class="eyebrow">Marco que sí se puede prometer</p>
      <h2 id="tramite-titulo">Ley Net Billing y trámite SEC TE4</h2>
      <p>El Net Billing chileno no es un trueque uno a uno de toda la tarifa. Primero dejas de comprar la energía que consumes mientras el sistema produce. Lo que sobra se inyecta, se valoriza y se abona en la boleta de CGE. El tope del régimen es 300 kW: una casa o una pyme del Norte Chico queda limitada por el techo y por la cuenta, no por esa cifra.</p>
      <p>La SEC no certifica a la marca. Certifica la instalación a través de un instalador eléctrico autorizado, que declara el TE4. Después la distribuidora revisa y cambia el medidor. Quien prometa conexión a red en 48 horas está saltándose ese orden. En off-grid y en bombeo aislado no hay inyección: el TE4 de conexión a red no aplica y no se usa como argumento de venta.</p>
    </div>
  </section>

  <section class="section" id="comunas" aria-labelledby="comunas-titulo">
    <div class="wrap">
      <p class="eyebrow">Doce localidades, encargos distintos</p>
      <h2 id="comunas-titulo">Comunas donde evaluamos proyectos</h2>
      <p class="section-lead">Cada página explica el problema local. No es el mismo texto con el nombre de la ciudad cambiado: la costa pide herraje inoxidable, el interior pide agua y Copiapó pide descontar el calor del techo.</p>
      <div class="grid-comunas">
        <?php foreach (comunas_principales() as $slug => $item): ?>
          <article class="card card-link">
            <p class="zone-region"><?= e($item['region_larga']) ?></p>
            <h3><?= e($item['nombre']) ?></h3>
            <p><?= e($item['card']) ?></p>
            <a href="<?= e($item['path']) ?>">Ver paneles solares en <?= e($item['nombre']) ?></a>
            <?php $hijos = satelites_de($slug); if ($hijos !== []): ?>
              <p class="fine" style="margin-top:8px">También: <?php
                $links = [];
                foreach ($hijos as $h) {
                    $links[] = '<a href="' . e($h['path']) . '">' . e($h['nombre']) . '</a>';
                }
                echo implode(' · ', $links);
              ?></p>
            <?php endif; ?>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section class="section section-alt" id="servicios-hub" aria-labelledby="servicios-hub-titulo">
    <div class="wrap">
      <p class="eyebrow">Silos de servicio</p>
      <h2 id="servicios-hub-titulo">Net Billing, off-grid, bombeo y empresas</h2>
      <div class="grid-2">
        <?php foreach (servicios() as $item): ?>
          <article class="card card-link">
            <h3><?= e($item['h1']) ?></h3>
            <p><?= e($item['card']) ?></p>
            <a href="<?= e($item['path']) ?>">Ver servicio</a>
          </article>
        <?php endforeach; ?>
      </div>
      <p class="fine"><a href="/servicios">Ver todos los servicios</a></p>
      <h3 class="subhead">Guías del Norte Chico</h3>
      <div class="grid-comunas">
        <?php foreach (guias() as $item): ?>
          <article class="card card-link">
            <h3><?= e($item['h1']) ?></h3>
            <p><?= e($item['description']) ?></p>
            <a href="<?= e($item['path']) ?>">Leer guía</a>
          </article>
        <?php endforeach; ?>
      </div>
      <p class="fine"><a href="/guias">Ver todas las guías</a></p>
    </div>
  </section>

  <section class="section" id="proceso" aria-labelledby="proceso-titulo">
    <div class="wrap">
      <p class="eyebrow">De la boleta al medidor</p>
      <h2 id="proceso-titulo">Cómo pasa un proyecto de la visita a la puesta en marcha</h2>
      <ol class="steps">
        <li>
          <h3>Filtro de comuna, uso y gasto</h3>
          <p>El formulario deja fuera al curioso sin superficie y ordena la prioridad. Una boleta sobre $120.000 o un pozo que se quiere mover este mes no espera lo mismo que alguien que solo está comparando kits.</p>
        </li>
        <li>
          <h3>Visita técnica en la zona</h3>
          <p>Se ve techo o pozo, tablero, sombras, corrosión y acceso. En la costa se mira el salitre. En Copiapó, el calor de la cubierta y el polvo. En el campo, el dato del agua.</p>
        </li>
        <li>
          <h3>Propuesta con lo que el sistema no hace</h3>
          <p>Se escribe la producción esperada con las pérdidas del lugar, y también qué cargas quedan fuera. Un número de catálogo a 25 °C no es una propuesta.</p>
        </li>
        <li>
          <h3>Instalación y TE4 si hay red</h3>
          <p>La cuadrilla monta, prueba y, cuando corresponde inyectar, el instalador autorizado ingresa el TE4. El medidor bidireccional lo pone la distribuidora.</p>
        </li>
      </ol>
    </div>
  </section>

  <section class="section" id="preguntas" aria-labelledby="faq-titulo">
    <div class="wrap">
      <p class="eyebrow">Respuestas directas</p>
      <h2 id="faq-titulo">Preguntas frecuentes del Norte Chico</h2>
      <div class="faq-list">
        <?php foreach ($faqs as $faq): ?>
          <details class="faq">
            <summary><h3><?= e($faq['q']) ?></h3></summary>
            <p><?= e($faq['a']) ?></p>
            <?php if (!empty($faq['extra'])): ?><p><?= e($faq['extra']) ?></p><?php endif; ?>
          </details>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section class="cta-band" aria-labelledby="cierre-titulo">
    <div class="wrap">
      <h2 id="cierre-titulo">Cuéntanos la comuna y el tipo de proyecto</h2>
      <p>Con eso se ve si corresponde visita este mes o si todavía es una consulta. El instalador de la zona responde por WhatsApp.</p>
      <a class="btn btn-amber" href="#precalificador">Empezar evaluación</a>
    </div>
  </section>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>

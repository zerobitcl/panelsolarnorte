<?php
declare(strict_types=1);

if (basename($_SERVER['SCRIPT_FILENAME'] ?? '') === 'comunas.php') {
    http_response_code(403);
    exit;
}

return [
    'la-serena' => [
        'slug' => 'la-serena',
        'nivel' => 'principal',
        'lastmod' => '2026-11-20',
        'hsp' => 5.4,
        'kwh_precio' => 271,
        'factor_perdidas' => 0.82,
        'casos' => [
  0 => 
  [
    'titulo' => 'Casa en El Milagro con boleta de verano',
    'texto' => 'Sistema on-grid de 4,5 a 5,5 kWp para una vivienda con aire acondicionado diurno y bomba de piscina.',
    'resultado' => 'Ahorro estimado 45-60% de la energía comprada en los meses de calor, con TE4 e inyección Net Billing.',
  ],
  1 => 
  [
    'titulo' => 'Parcela en San Joaquín sin empalme',
    'texto' => 'Kit off-grid con baterías para refrigerador, luces, internet y bomba chica de agua.',
    'resultado' => 'Autonomía nocturna de un día típico de fin de semana sin depender del generador.',
  ],
],
        'nombre' => 'La Serena',
        'region' => 'Coquimbo',
        'region_larga' => 'Región de Coquimbo',
        'path' => '/paneles-solares-la-serena',
        'title' => 'Paneles Solares en La Serena | Net Billing y SEC',
        'description' => 'Instalación de paneles solares en La Serena para bajar la boleta CGE e inyectar excedentes con Net Billing. Parcelas de El Milagro, San Joaquín y Elqui con trámite SEC TE4.',
        'h1' => 'Instalación de Paneles Solares en La Serena con Certificación SEC',
        'eyebrow' => 'La Serena · Región de Coquimbo',
        'lead' => 'En La Serena el consumo que más duele no es el de julio: es el de enero, cuando el aire acondicionado de la casa y la bomba de la piscina coinciden con la tarifa CGE. Un sistema on-grid se dimensiona sobre esa curva, cubre el uso diurno e inyecta el excedente bajo la Ley de Net Billing. En parcelas de El Milagro, San Joaquín o la salida al Valle de Elqui, donde el empalme todavía no llega o la factibilidad sale más cara que la casa, el equipo correcto es un kit off-grid, no un inversor de red.',
        'card' => 'Casas urbanas y parcelas hacia Elqui. Ahorro de boleta CGE, Net Billing y kits con batería donde no hay empalme.',
        'contexto_titulo' => 'Qué está empujando el gasto eléctrico en La Serena',
        'dolores' => [
            [
                'titulo' => 'Verano largo y boleta CGE',
                'texto' => 'Las Compañías, La Florida, El Milagro y el centro no tienen el mismo techo ni la misma cuenta, pero comparten el pico de climatización. Si la boleta de diciembre a marzo supera los $120.000, el diseño parte de esos meses y no de un promedio anual que esconde el problema.',
            ],
            [
                'titulo' => 'Parcelas con factibilidad cara',
                'texto' => 'Hacia San Joaquín y la salida oriente, muchos sitios pagan primero la extensión de red. Cuando ese presupuesto se come el proyecto, conviene comparar un off-grid bien calculado (consumos reales de bomba, refrigerador e iluminación) contra el costo del empalme, no contra un kit genérico de mercado.',
            ],
            [
                'titulo' => 'Techos con estanques y vecinos altos',
                'texto' => 'En la ciudad el límite no es el sol: es la sombra del estanque, del segundo piso del vecino o de la losa del departamento de al lado. Eso se resuelve en la visita, con string partido o microinversores solo donde hay sombra parcial. En un techo despejado no hace falta encarecer el sistema.',
            ],
        ],
        'nota_filtro' => 'Si vives en departamento sin acceso legal al techo, no hay superficie donde instalar. El proyecto necesita cubierta o terreno propio.',
        'servicios_titulo' => 'Sistemas que instalamos en La Serena',
        'servicios' => [
            [
                'titulo' => 'On-grid residencial y Net Billing',
                'texto' => 'Para casas con empalme. El inversor se conecta al tablero, el medidor pasa a bidireccional y los excedentes se descuentan en la boleta CGE. El trámite ante la SEC es el TE4, declarado por un instalador eléctrico autorizado, no por el propietario.',
                'puntos' => ['Hasta 300 kW según la Ley 21.118', 'Autoconsumo de día antes que inyección', 'Diseño sobre la boleta de verano'],
            ],
            [
                'titulo' => 'Off-grid en parcelas del Elqui',
                'texto' => 'Para sitios sin empalme en El Milagro, San Joaquín y la salida al valle. Lleva baterías, un inversor cargador y un tablero propio. No inyecta a la red y no reemplaza un grupo electrógeno si alguien quiere aire acondicionado toda la noche sin haberlo dicho en la visita.',
                'puntos' => ['Consumos nocturnos explícitos', 'Respaldo real, no una batería de adorno', 'Sin trámite de conexión a CGE'],
            ],
            [
                'titulo' => 'Estructura para losa, teja y zinc',
                'texto' => 'La Serena no tiene la sal de Tongoy, pero el viento de la costa sí mueve una estructura mal anclada. Se usa fijación según el material del techo y pasadas selladas. En losa, la inclinación se da con la estructura, no apoyando el módulo plano.',
                'puntos' => ['Anclaje según cubierta', 'Separación para ventilar el módulo', 'Canalización ordenada hasta el tablero'],
            ],
        ],
        'zonas_titulo' => 'Sectores de La Serena donde más evaluamos',
        'zonas' => [
            ['nombre' => 'El Milagro', 'texto' => 'Casas nuevas y parcelas en consolidación. Hay techos buenos y también sitios donde la red todavía queda corta. Se define on-grid u off-grid según exista empalme, no según el folleto.'],
            ['nombre' => 'San Joaquín', 'texto' => 'Parcelas más grandes, bombas chicas y consumo de fin de semana que no se parece al de una casa urbana. El diseño separa carga permanente y carga ocasional.'],
            ['nombre' => 'Las Compañías', 'texto' => 'Techos residenciales con poco espacio y cuentas familiares altas en verano. Aquí pesa más el orden del string y la sombra de acumuladores que la potencia de catálogo.'],
            ['nombre' => 'Salida al Valle de Elqui', 'texto' => 'Hacia el oriente baja la camanchaca y sube la radiación respecto de la costanera. Sirve para parcelas de agrado, siempre que el acceso del equipo y del instalador esté resuelto antes de prometer fecha.'],
        ],
        'proceso_titulo' => 'Cómo es la instalación en La Serena',
        'proceso_intro' => 'En la costa serenense la mañana de invierno suele venir con camanchaca. Esa nube baja no se diseña igual que un techo de Copiapó: la generación parte más tarde y el verano, en cambio, es largo y despejado. Por eso no se copia una estimación de Atacama en una casa de Avenida del Mar.',
        'pasos' => [
            ['titulo' => 'Boleta y techo', 'texto' => 'Pedimos 12 meses de boleta CGE, o el consumo estimado si la casa es nueva, y fotos del techo. Con eso se ve si el proyecto se paga con el pico de verano o si la cuenta es demasiado baja.'],
            ['titulo' => 'Visita en la comuna', 'texto' => 'Se mide cubierta, tablero, sombras y espacio del inversor. En parcelas sin red se anota cada consumo nocturno: si no está en la lista, la batería no lo va a adivinar.'],
            ['titulo' => 'TE4 cuando hay red', 'texto' => 'El instalador autorizado ingresa la declaración TE4 a la SEC. El plazo siguiente lo marcan la SEC y CGE para el medidor bidireccional. No se promete un día fijo porque no depende solo de la cuadrilla.'],
            ['titulo' => 'Puesta en marcha', 'texto' => 'Se prueba producción, protecciones y la app de monitoreo si el inversor la trae. En off-grid se deja escrito qué cargas no entran al sistema.'],
        ],
        'cierre' => 'Si tu casa está en La Serena y la boleta de verano ya duele, o la parcela sigue esperando empalme, la evaluación parte por la comuna y el tipo de red. No pedimos el techo completo para decirte si el caso merece visita.',
        'faqs' => [
            [
                'q' => '¿Conviene Net Billing en La Serena si la casa consume de noche?',
                'a' => 'Conviene cuando una parte relevante del consumo cae de día: aire acondicionado, teletrabajo, bomba o refrigeración. Lo que se usa de noche se sigue comprando a CGE, salvo que el proyecto sea off-grid con baterías.',
                'extra' => 'En Net Billing el excedente diurno se valoriza y se descuenta en la boleta; no es un peso a peso de toda la tarifa. Por eso el tamaño del sistema sale de la boleta, no del máximo de paneles que entran en el techo.',
            ],
            [
                'q' => '¿Instalan en parcelas de El Milagro o San Joaquín sin empalme?',
                'a' => 'Sí. Esos sitios se resuelven con kit off-grid: paneles, baterías e inversor cargador, sin inyección a la red.',
                'extra' => 'Antes de cotizar se listan las cargas de noche. Una parcela de fin de semana y una casa habitada toda la semana no llevan la misma batería ni el mismo presupuesto.',
            ],
            [
                'q' => '¿Cuánto demora el trámite SEC TE4 en La Serena?',
                'a' => 'El TE4 lo ingresa el instalador eléctrico autorizado. Después de eso, el calendario lo definen la SEC y CGE para revisar y cambiar el medidor.',
                'extra' => 'La instalación física de un residencial suele ser más corta que la espera del medidor bidireccional. Quien prometa conexión a red en 48 horas está omitiendo el trámite.',
            ],
            [
                'q' => '¿Sirve un techo de losa en La Serena?',
                'a' => 'Sí, si hay superficie despejada y se puede anclar sin filtrar la losa. El módulo no va pegado plano: se levanta para darle inclinación y ventilación.',
                'extra' => 'Si el techo útil es chico por estanques o construcciones vecinas, se declara esa sombra en la visita. A veces el sistema rinde más con menos módulos bien puestos.',
            ],
            [
                'q' => '¿El ahorro cubre la boleta CGE completa?',
                'a' => 'No de forma automática. El ahorro fuerte está en la energía que dejas de comprar mientras el sistema produce, sobre todo en los meses de aire acondicionado.',
                'extra' => 'Cargos fijos y consumos nocturnos siguen en la cuenta on-grid. Si la boleta anual es baja, el proyecto puede no justificarse y la evaluación tiene que decirlo.',
            ],
        ],
    ],
    'coquimbo' => [
        'slug' => 'coquimbo',
        'nivel' => 'principal',
        'lastmod' => '2026-11-20',
        'hsp' => 5.3,
        'kwh_precio' => 271,
        'factor_perdidas' => 0.78,
        'casos' => [
  0 => 
  [
    'titulo' => 'Restaurante en Guanaqueros',
    'texto' => 'On-grid costero con estructura anodizada e IP65 para frío y cocina diurna.',
    'resultado' => 'Cubre gran parte del consumo de apertura; el herraje de costa evita fallas por salitre.',
  ],
  1 => 
  [
    'titulo' => 'Casa en Peñuelas',
    'texto' => 'Sistema residencial on-grid dimensionado sobre la boleta CGE de verano.',
    'resultado' => 'Baja la energía comprada de día; el Net Billing abona el excedente.',
  ],
],
        'nombre' => 'Coquimbo',
        'region' => 'Coquimbo',
        'region_larga' => 'Región de Coquimbo',
        'path' => '/paneles-solares-coquimbo',
        'title' => 'Paneles Solares en Coquimbo | Costa y Pymes',
        'description' => 'Paneles solares en Coquimbo para casas y pymes de Sindempart, Peñuelas, Tierras Blancas, Tongoy y Guanaqueros. Estructura anticorrosión, IP65/IP66 y Net Billing.',
        'h1' => 'Instalación de Paneles Solares en Coquimbo Resistentes a la Corrosión Salina',
        'eyebrow' => 'Coquimbo · Bahía y costa',
        'lead' => 'Coquimbo no se diseña como La Serena interior. Aquí el enemigo del sistema es la combinación de humedad, viento sur y salitre: en la costanera, en Guanaqueros y en Tongoy un herraje galvanizado común y una caja IP54 se oxidan antes de que el inversor recupere la inversión. El proyecto, residencial o de pyme, parte por materiales de costa —aluminio anodizado, pernería inoxidable y gabinetes IP65 o IP66— y recién después por la cantidad de módulos.',
        'card' => 'Costa, pymes y caletas. Prioridad a estructura anodizada, pernería inoxidable y equipos IP65/IP66.',
        'contexto_titulo' => 'Por qué en Coquimbo el material manda más que el watt',
        'dolores' => [
            [
                'titulo' => 'Salitre en Sindempart, la costa y las caletas',
                'texto' => 'A pocas cuadras del mar el aerosol salino entra en bornes, rieles y tornillos. Una estructura pensada para el valle del interior dura poco en Guanaqueros o en el borde de la bahía. Se especifica aluminio anodizado y, donde el rocío es directo, pernería inoxidable A4 en vez de A2.',
            ],
            [
                'titulo' => 'Pymes que pagan la luz en horario comercial',
                'texto' => 'Locales de Peñuelas, Tierras Blancas, restaurantes de Guanaqueros y hospedajes de Tongoy consumen de día: frío, horno, bombas y iluminación. Ese perfil calza mejor con un on-grid que una casa vacía hasta las 19:00. El tamaño sale de la cuenta de la pyme, no de la casa del dueño.',
            ],
            [
                'titulo' => 'Viento y anclaje, no solo corrosión',
                'texto' => 'En Tongoy y en la costanera el viento levanta un arreglo con pocos puntos de fijación. El cálculo de anclaje va con el tipo de cubierta —zinc, losa o estructura de local— y con sellos que no dejen la filtración como costo oculto.',
            ],
        ],
        'nota_filtro' => 'No tomamos fachadas de departamento sin permiso del edificio ni techos arrendados donde el contrato prohíbe intervenir la cubierta.',
        'servicios_titulo' => 'Sistemas que aguantan la costa de Coquimbo',
        'servicios' => [
            [
                'titulo' => 'On-grid para casa y comercio',
                'texto' => 'Con empalme CGE, el sistema cubre el consumo diurno del local o de la casa e inyecta el excedente por Net Billing. En un restaurante o un minimarket el ahorro aparece en el horario en que el negocio está abierto, que es justo cuando el sol produce.',
                'puntos' => ['Perfil comercial diurno', 'TE4 ingresado por instalador SEC', 'Medidor bidireccional con CGE'],
            ],
            [
                'titulo' => 'Estructura y cajas para ambiente salino',
                'texto' => 'Rieles de aluminio anodizado, grapas del mismo material, pernería inoxidable y cajas de conexión IP65 o IP66. El inversor no queda a la intemperie sin gabinete cuando el muro recibe rocío. Los prensaestopas tienen que cerrar de verdad: por ahí entra la sal aunque el módulo sea bueno.',
                'puntos' => ['Aluminio anodizado', 'Inoxidable A2 o A4 según exposición', 'IP65/IP66 en cajas y protecciones de intemperie'],
            ],
            [
                'titulo' => 'Off-grid puntual, no como receta de puerto',
                'texto' => 'La mayoría de Coquimbo urbano tiene red. El off-grid se reserva para parcelas y puestos costeros donde el empalme no llega. Llevar baterías a un local que ya tiene medidor suele ser un gasto que la boleta no paga.',
                'puntos' => ['Solo si no hay empalme viable', 'Cargas nocturnas declaradas', 'Sin inyección a la red'],
            ],
        ],
        'zonas_titulo' => 'Dónde cambia el diseño dentro de Coquimbo',
        'zonas' => [
            ['nombre' => 'Sindempart y Peñuelas', 'texto' => 'Casas y locales con red estable. El foco es la boleta y el estado del tablero. La corrosión existe, pero no es la de un techo frente a la rompiente.'],
            ['nombre' => 'Tierras Blancas', 'texto' => 'Techos residenciales con buen uso diurno familiar. Se revisa sombra de construcciones cercanas antes de llenar el faldón de módulos.'],
            ['nombre' => 'Tongoy', 'texto' => 'Viento, sal y hospedajes con consumo de temporada. El anclaje y el IP del equipo importan tanto como el ahorro de los meses de verano.'],
            ['nombre' => 'Guanaqueros', 'texto' => 'Caleta y restaurantes pegados al mar. Aquí la pernería inoxidable y las cajas estancas no son un extra: son la diferencia entre un sistema que sigue produciendo y uno que se sulfata.'],
        ],
        'proceso_titulo' => 'Cómo se instala en ambiente marino',
        'proceso_intro' => 'La camanchaca de la bahía recorta la mañana de invierno, igual que en La Serena, pero suma corrosión. Un rendimiento copiado de Ovalle o de Copiapó queda alto para un techo de Tongoy. La propuesta de Coquimbo declara esa pérdida y el recambio de fijaciones expuestas.',
        'pasos' => [
            ['titulo' => 'Cuenta y distancia al mar', 'texto' => 'Además de la boleta se pregunta a cuántas cuadras está el rocío directo. No es lo mismo Partronato que la primera línea de Guanaqueros, y el herraje cambia.'],
            ['titulo' => 'Visita de cubierta y tablero', 'texto' => 'Se revisa óxido existente, tipo de zinc o losa, y si el tablero aguanta la conexión. En un local se anota el horario real de frío y cocina.'],
            ['titulo' => 'Especificación de costa', 'texto' => 'La cotización nombra anodizado, inoxidable e IP. Si un presupuesto de Coquimbo no dice nada de corrosión, está cotizando un sistema de interior.'],
            ['titulo' => 'TE4 y monitoreo', 'texto' => 'En on-grid se ingresa el TE4 y se deja monitoreo para ver si una caja o un string cae después de un temporal de sur. En off-grid se prueba la batería con las cargas acordadas.'],
        ],
        'cierre' => 'Si el local está en la bahía o la casa mira al mar, pide la evaluación con la comuna Coquimbo ya marcada. El filtro siguiente es si hay empalme y si la cuenta justifica el material de costa, que es más caro que el del valle y tiene que serlo.',
        'faqs' => [
            [
                'q' => '¿Qué materiales resisten la sal en Coquimbo, Tongoy y Guanaqueros?',
                'a' => 'Estructura de aluminio anodizado, pernería inoxidable y cajas IP65 o IP66. En rocío directo se usa inoxidable A4, no tornillo galvanizado de interior.',
                'extra' => 'El módulo también se ensucia con sal y polvo. El diseño deja acceso para lavar con agua, sin pisar el arreglo ni apoyar herramientas sobre el vidrio.',
            ],
            [
                'q' => '¿Un restaurante o pyme en Coquimbo ahorra más que una casa?',
                'a' => 'Suele ahorrar mejor cuando el consumo fuerte es de día: refrigeración, cocina, bombas y caja. Ese horario coincide con la producción solar.',
                'extra' => 'Una casa vacía hasta la noche inyecta casi todo y el beneficio del Net Billing es menor. Por eso el formulario separa casa y empresa antes de cotizar.',
            ],
            [
                'q' => '¿El inversor puede quedar a la intemperie frente al mar?',
                'a' => 'No como regla. En primera línea va en muro protegido o gabinete con el IP que corresponde, y los prensaestopas tienen que quedar cerrados.',
                'extra' => 'Un inversor de interior instalado en un corredor abierto de Tongoy es la falla más cara y más evitable de la costa.',
            ],
            [
                'q' => '¿También hacen Net Billing en Coquimbo?',
                'a' => 'Sí, en inmuebles con empalme. Se ingresa el TE4 a la SEC y CGE cambia a medidor bidireccional. El excedente se descuenta en la boleta; no borra el cargo fijo ni el consumo nocturno.',
                'extra' => 'El tope legal de autoconsumo para este régimen es 300 kW. Un local de barrio queda muy por debajo; el límite real es el techo y la cuenta.',
            ],
            [
                'q' => '¿Atienden parcelas costeras sin luz en Coquimbo?',
                'a' => 'Sí, con kit off-grid, cuando el empalme no existe o la factibilidad no se paga con el uso del sitio.',
                'extra' => 'No es el caso de la mayoría de Sindempart, Peñuelas o Tierras Blancas, que ya tienen red. Ahí el on-grid es el camino.',
            ],
        ],
    ],
    'ovalle' => [
        'slug' => 'ovalle',
        'nivel' => 'principal',
        'lastmod' => '2026-11-20',
        'hsp' => 5.8,
        'kwh_precio' => 256,
        'factor_perdidas' => 0.86,
        'casos' => [
  0 => 
  [
    'titulo' => 'Pozo de riego en el Limarí',
    'texto' => 'Bombeo solar directo a tranque, sin batería, para riego diurno.',
    'resultado' => 'Reemplaza el diésel de mediodía en temporada de riego con agua acumulada.',
  ],
  1 => 
  [
    'titulo' => 'Parcela en Sotaquí',
    'texto' => 'Off-grid de casa más arreglo aparte para bomba chica.',
    'resultado' => 'Habitación nocturna y riego diurno sin mezclar presupuestos.',
  ],
],
        'nombre' => 'Ovalle',
        'region' => 'Coquimbo',
        'region_larga' => 'Región de Coquimbo',
        'path' => '/paneles-solares-ovalle',
        'title' => 'Paneles Solares en Ovalle | Bombeo Agrícola',
        'description' => 'Paneles solares en Ovalle para bombeo de pozos y riego del Limarí, parcelas off-grid sin empalme y casas urbanas. Visita técnica en el Valle del Limarí.',
        'h1' => 'Instalación de Paneles Solares en Ovalle para Riego y Bombeo Agrícola',
        'eyebrow' => 'Ovalle · Valle del Limarí',
        'lead' => 'En Ovalle hay dos encargos que no se cotizan igual. El primero es un pozo o un riego tecnificado en el Limarí: la bomba trabaja de día, el diésel ya no cierra y el sol del interior es más estable que en la costa. El segundo es la parcela de agrado sin empalme, en salidas como Sotaquí o hacia el río, donde hace falta un off-grid y no un inversor de red. La casa del radio urbano es un tercer caso, más simple: boleta CGE y Net Billing, parecido a una vivienda, no a un campo.',
        'card' => 'Bombeo de pozos y riego en el Limarí, más parcelas sin empalme y casas de la ciudad.',
        'contexto_titulo' => 'El Limarí no compra paneles: compra agua a la hora del sol',
        'dolores' => [
            [
                'titulo' => 'Diésel en pozos y riego tecnificado',
                'texto' => 'Un generador regando al mediodía quema combustible justo cuando el arreglo fotovoltaico produce más. El bombeo solar directo —sin batería, a tranque o a la línea de goteo— suele ser el primer diseño. La batería entra solo si hay que regar de noche o sostener una casa en el mismo sistema.',
            ],
            [
                'titulo' => 'Profundidad y caudal, no una potencia de memoria',
                'texto' => 'No se elige la bomba por una foto del pozo. Hace falta profundidad, nivel dinámico, caudal que el pozo aguanta y la altura hasta el tranque. Con esos datos se ve si el solar reemplaza el diésel o si el pozo pide más de lo que el campo puede financiar.',
            ],
            [
                'titulo' => 'Parcelas de agrado sin empalme',
                'texto' => 'En Sotaquí, La Chimba y otras salidas del valle hay sitios habitados el fin de semana o toda la semana, sin red. El off-grid se calcula con refrigerador, iluminación, bomba chica y, si alguien insiste, aire acondicionado. Esa última carga cambia el presupuesto de baterías de forma brutal y hay que decirlo antes.',
            ],
        ],
        'nota_filtro' => 'No dimensionamos bombeo sin datos del pozo. Si no hay profundidad ni caudal, la visita sirve para medir, no para dejar un número cerrado.',
        'servicios_titulo' => 'Qué se instala en Ovalle y el Limarí',
        'servicios' => [
            [
                'titulo' => 'Bombeo solar agrícola',
                'texto' => 'Arreglo fotovoltaico dedicado a la bomba, con variador o controlador de bombeo, protecciones y partida suave. El objetivo es mover agua en las horas de sol hacia un tranque, que es la batería más barata del campo.',
                'puntos' => ['Prioridad al riego diurno', 'Tranque como almacenamiento', 'Menos diésel en la temporada'],
            ],
            [
                'titulo' => 'Off-grid de parcela',
                'texto' => 'Para sitios del valle sin empalme. Incluye baterías dimensionadas a la noche real, no a una noche imaginaria de ciudad. Se separa la bomba de riego del consumo de la casa cuando mezclarlos obliga a sobredimensionar todo.',
                'puntos' => ['Casa y riego por separado si conviene', 'Listado de cargas firmado en la visita', 'Sin TE4 de conexión, porque no hay red'],
            ],
            [
                'titulo' => 'On-grid en la ciudad de Ovalle',
                'texto' => 'Viviendas y locales con medidor CGE. El cielo del interior es más claro que el de la bahía, así que no se usa la estimación costera. El trámite de inyección es el TE4 y el medidor bidireccional.',
                'puntos' => ['Boleta urbana de verano', 'Net Billing hasta 300 kW', 'Techos de casa y local'],
            ],
        ],
        'zonas_titulo' => 'Sectores del valle con encargos distintos',
        'zonas' => [
            ['nombre' => 'Ciudad de Ovalle', 'texto' => 'Casas y comercios con red. El encargo es bajar la boleta, no sacar agua. Se mira tablero, techo y doce meses de cuenta.'],
            ['nombre' => 'Sotaquí y La Chimba', 'texto' => 'Parcelas y agricultura cercana. Aparecen off-grid y bombeos chicos en el mismo camino. Se visita con tiempo de traslado, no como un domicilio urbano.'],
            ['nombre' => 'Riego del Limarí', 'texto' => 'Pozos y sistemas tecnificados donde el horario de riego puede moverse al día. Si el cultivo exige riego nocturno fijo, el solar directo no alcanza y hay que decirlo.'],
            ['nombre' => 'Salidas a Monte Patria y el río', 'texto' => 'Campos y parcelas de agrado. Se confirma acceso de camioneta y un lugar seco para el variador antes de cerrar fecha de instalación.'],
        ],
        'proceso_titulo' => 'Cómo se evalúa un campo en Ovalle',
        'proceso_intro' => 'Ovalle está al interior: menos camanchaca que Coquimbo y un perfil de generación más parejo en el día. Eso favorece el riego a mediodía. No sirve de nada si el pozo rinde de madrugada por un turno que el campo no puede cambiar. La primera pregunta es el horario del agua, no la marca del panel.',
        'pasos' => [
            ['titulo' => 'Datos del agua o de la boleta', 'texto' => 'En bombeo: profundidad, caudal, horas de riego y si existe tranque. En casa: boleta CGE. En parcela sin red: lista de equipos y horas de uso.'],
            ['titulo' => 'Visita al pozo o al techo', 'texto' => 'Se ve el generador actual, el tablero de la bomba y la distancia al tranque. En ciudad se ve la cubierta. No se firma potencia a ciegas.'],
            ['titulo' => 'Diseño de temporada', 'texto' => 'La propuesta muestra cuánta agua o cuántos kWh caen en los meses de riego, que no son los mismos de una casa en La Serena.'],
            ['titulo' => 'Instalación y trámite solo si hay red', 'texto' => 'El TE4 aplica al on-grid urbano o a un empalme de campo que sí inyecte. El bombeo aislado y el off-grid no se conectan a CGE y no se venden como si lo hicieran.'],
        ],
        'cierre' => 'Si el pozo está en el Limarí o la parcela de Ovalle sigue a vela y generador, marca Ovalle en el formulario y el tipo de proyecto. Con el gasto de diésel o de boleta se ve si la visita va al campo o si el caso todavía es chico.',
        'faqs' => [
            [
                'q' => '¿El bombeo solar funciona en un pozo profundo del Limarí?',
                'a' => 'Funciona cuando el caudal del pozo, la profundidad y las horas de sol alcanzan para llenar el tranque o regar en el día. No depende solo de poner más paneles.',
                'extra' => 'Sin nivel, caudal y altura hasta el estanque no hay potencia seria. Esos tres datos valen más que la marca del módulo.',
            ],
            [
                'q' => '¿Hace falta batería para regar con sol en Ovalle?',
                'a' => 'No, si el riego puede hacerse de día y hay tranque. La batería se agrega para la casa o para un turno nocturno que el cultivo no puede mover.',
                'extra' => 'Meter baterías a un bombeo que podría ser directo encarece el campo y agrega un recambio que el agua no pedía.',
            ],
            [
                'q' => '¿Instalan off-grid en parcelas de Sotaquí o La Chimba?',
                'a' => 'Sí, en sitios sin empalme. El sistema alimenta la casa con baterías y puede dejar la bomba de riego en un arreglo aparte.',
                'extra' => 'El aire acondicionado toda la noche en una parcela off-grid multiplica las baterías. Se cotiza explícito o se deja fuera.',
            ],
            [
                'q' => '¿Una casa en la ciudad de Ovalle puede usar Net Billing?',
                'a' => 'Sí. Con empalme CGE se ingresa el TE4 y el excedente diurno se descuenta en la boleta. El cielo de Ovalle es de interior, más claro que el de la costa, y el cálculo usa esa condición.',
                'extra' => 'Si la casa consume casi todo después de las 20:00 y la boleta es baja, el on-grid puede no pagarse. La evaluación lo dice antes de la visita larga.',
            ],
            [
                'q' => '¿Pueden reemplazar el generador diésel completo?',
                'a' => 'Pueden sacar el diésel de las horas de sol y, con tranque, gran parte del riego. No prometemos apagar el generador de respaldo si el pozo también tiene que trabajar con cielo cubierto toda una semana de riego crítico.',
                'extra' => 'El respaldo se conversa con el calendario del cultivo, no se esconde en la letra chica.',
            ],
        ],
    ],
    'copiapo' => [
        'slug' => 'copiapo',
        'nivel' => 'principal',
        'lastmod' => '2026-11-20',
        'hsp' => 6.5,
        'kwh_precio' => 266,
        'factor_perdidas' => 0.8,
        'casos' => [
  0 => 
  [
    'titulo' => 'Casa con aire acondicionado en El Palomar',
    'texto' => 'On-grid ventilado de 5 a 6 kWp orientado al consumo diurno de clima.',
    'resultado' => 'Ataque al pico de verano; el diseño descuenta calor de celda y polvo.',
  ],
  1 => 
  [
    'titulo' => 'Faena chica hacia Paipote',
    'texto' => 'Off-grid robusto con partida de bomba y gabinete estanco.',
    'resultado' => 'Opera sin esperar factibilidad de red; batería calculada a cargas reales.',
  ],
],
        'nombre' => 'Copiapó',
        'region' => 'Atacama',
        'region_larga' => 'Región de Atacama',
        'path' => '/paneles-solares-copiapo',
        'title' => 'Paneles Solares en Copiapó | Off-Grid y Pymes',
        'description' => 'Paneles solares en Copiapó para parcelas off-grid, pymes y faenas chicas, y para bajar el costo del aire acondicionado. Diseño para calor, polvo y radiación de Atacama.',
        'h1' => 'Instalación de Paneles Solares en Copiapó para Parcelas, Pymes y Faenas',
        'eyebrow' => 'Copiapó · Región de Atacama',
        'lead' => 'Copiapó tiene la radiación más alta de las cinco comunas que cubrimos, y también el techo más caliente. El módulo pierde potencia cuando la celda se dispara sobre los 25 °C, así que un arreglo pegado a una plancha metálica en enero produce menos de lo que sugiere el folleto del desierto. El trabajo aquí es doble: off-grid robusto para parcelas y faenas chicas sin un empalme razonable, y on-grid para casas y pymes donde el aire acondicionado es la boleta.',
        'card' => 'Alta radiación de Atacama, off-grid de parcelas y faenas, y alivio del aire acondicionado en la ciudad.',
        'contexto_titulo' => 'En Copiapó el sol sobra y el calor cobra',
        'dolores' => [
            [
                'titulo' => 'Aire acondicionado que domina la cuenta',
                'texto' => 'En la ciudad el kWh caro es el del calor, de noviembre a marzo, en casas y en oficinas que no pueden apagar el equipo a las 11. Un on-grid bien ventilado ataca esa franja diurna. No promete dejar la boleta en cero si la casa sigue helada toda la noche.',
            ],
            [
                'titulo' => 'Polvo y temperatura de celda',
                'texto' => 'El polvo del valle se deposita y el calor de techo deratinga el módulo. Se deja cámara de aire bajo la estructura, no un montaje pegado, y un acceso real para lavar. Sin lavado, la radiación de Atacama se queda en el vidrio sucio.',
            ],
            [
                'titulo' => 'Parcelas y faenas fuera de la red fácil',
                'texto' => 'Hacia Paipote, el poniente y la salida del valle hay parcelas, bodegas y faenas de servicio donde la factibilidad eléctrica no conversa con el plazo de la obra. Ahí el off-grid tiene que aguantar polvo, partida de motores y un uso que no es el de una casa de descanso.',
            ],
        ],
        'nota_filtro' => 'No diseñamos plantas industriales ni campamentos mineros de gran escala. El alcance es casa, pyme, parcela y faena de servicios.',
        'servicios_titulo' => 'Sistemas pensados para el calor de Copiapó',
        'servicios' => [
            [
                'titulo' => 'On-grid contra la cuenta de climatización',
                'texto' => 'Para viviendas y pymes con empalme. El sistema cubre el día de aire acondicionado, frío de local y oficina, e inyecta el excedente por Net Billing con TE4. La estructura va separada de la cubierta para que el módulo no trabaje a la temperatura de una plancha al sol.',
                'puntos' => ['Foco en el consumo diurno de verano', 'Montaje ventilado', 'Trámite SEC cuando hay inyección'],
            ],
            [
                'titulo' => 'Off-grid de parcela y faena',
                'texto' => 'Baterías, inversor capaz de partir motores chicos y tablero separado de las cargas que no entran. Se declara si hay soldadora, bomba o contenedor refrigerado: esas partidas no se esconden detrás de un kit de iluminación.',
                'puntos' => ['Partida de motores considerada', 'Polvo y caja estanca', 'Sin venderlo como conexión a la red'],
            ],
            [
                'titulo' => 'Mantenimiento de suciedad en el diseño',
                'texto' => 'El desierto no limpia los módulos con lluvia seguida. La propuesta deja pasillos o un borde seguro para lavar, y dice con qué frecuencia aproximada un techo de Copiapó pierde producción si nadie lo toca.',
                'puntos' => ['Acceso de lavado', 'Pérdida por suciedad explicada', 'Sin prometer el dato de laboratorio todo el año'],
            ],
        ],
        'zonas_titulo' => 'Copiapó no es un solo techo',
        'zonas' => [
            ['nombre' => 'Ciudad y El Palomar', 'texto' => 'Casas y locales con aire acondicionado. Hay red, hay boleta y el encargo es on-grid. Se revisa el tablero porque muchos equipos de clima ya lo dejaron justo.'],
            ['nombre' => 'Paipote', 'texto' => 'Polvo, actividad productiva y sitios mixtos. El gabinete y el filtro del mantenimiento pesan más que en un condominio nuevo.'],
            ['nombre' => 'Salida poniente y parcelas', 'texto' => 'Parcelas camino a la costa del valle donde el empalme se alarga. Off-grid si la red no llega a tiempo, on-grid si el medidor ya está.'],
            ['nombre' => 'Salida al valle', 'texto' => 'Bodegas, packing chico y casas hacia Tierra Amarilla atendidos desde Copiapó. Se confirma distancia y acceso antes de comprometer un día de instalación.'],
        ],
        'proceso_titulo' => 'Cómo se diseña con radiación alta y calor',
        'proceso_intro' => 'Copiar el kWh de catálogo de un módulo a 25 °C es el error típico en Atacama. En Copiapó se descuenta temperatura de celda y suciedad, y se gana igual porque la radiación anual es alta. El número honesto sigue siendo mejor que el del folleto.',
        'pasos' => [
            ['titulo' => 'Verano real de la cuenta', 'texto' => 'Se leen los meses de aire acondicionado, no solo el promedio. En una faena se listan motores, horas y si el turno es diurno.'],
            ['titulo' => 'Visita al calor de techo', 'texto' => 'Se ve cubierta metálica o losa, espacio para separar la estructura y dónde no va a quedar el inversor cocinándose. En parcela se ve sombra útil para las baterías.'],
            ['titulo' => 'Propuesta con pérdidas dichas', 'texto' => 'La cotización explica derating por calor y una rutina de lavado. En on-grid se incluye el TE4. En off-grid se incluye qué carga queda fuera.'],
            ['titulo' => 'Montaje y prueba de partida', 'texto' => 'Se prueba el sistema con las cargas críticas, no solo en vacío. Una faena que no parte la bomba el día de la entrega no está terminada.'],
        ],
        'cierre' => 'Si estás en Copiapó y la cuenta se va en clima, o la parcela y la faena siguen con generador, elige la comuna y el tipo de proyecto. Con el gasto mensual se distingue un lead que merece visita de uno que todavía está mirando precios de kit.',
        'faqs' => [
            [
                'q' => '¿La radiación de Copiapó garantiza más generación que en la costa?',
                'a' => 'La radiación anual es más alta que en La Serena o Coquimbo, sí. Parte de esa ventaja se la come el calor de la celda y el polvo si el montaje va pegado y nadie lava.',
                'extra' => 'Un diseño de Atacama deja ventilación bajo el módulo y acceso de limpieza. Sin eso, el folleto del desierto no se cumple en el techo.',
            ],
            [
                'q' => '¿Sirve para bajar el aire acondicionado de una casa en Copiapó?',
                'a' => 'Sirve para la porción que funciona de día. Esas horas son muchas en verano y por eso el on-grid calza mejor aquí que en una casa que solo enciende luces de noche.',
                'extra' => 'El equipo encendido de madrugada se sigue pagando a la distribuidora, salvo que el proyecto sea off-grid y las baterías estén calculadas para esa carga, lo que lo encarece.',
            ],
            [
                'q' => '¿Hacen off-grid para parcelas y faenas chicas?',
                'a' => 'Sí. Se dimensiona con las partidas reales: bomba, herramientas, frío o un contenedor. No se usa un kit de cabaña para una faena.',
                'extra' => 'Quedan fuera los campamentos mineros grandes y las plantas de potencia. Eso es otro oficio y otro contrato.',
            ],
            [
                'q' => '¿Hay Net Billing en Copiapó?',
                'a' => 'Sí, en instalaciones con empalme, mediante declaración TE4 ante la SEC y medidor bidireccional de la distribuidora. El marco es la Ley de Net Billing, con tope de 300 kW.',
                'extra' => 'El excedente se valoriza y se descuenta; no es un canje uno a uno de toda la tarifa, y el calor del techo ya está considerado en la energía que de verdad vas a inyectar.',
            ],
            [
                'q' => '¿Cada cuánto hay que lavar los paneles en Copiapó?',
                'a' => 'Más seguido que en la costa con llovizna. En temporada seca, un techo urbano polvoriento puede pedir lavado varias veces al año para no dejar producción pegada en el vidrio.',
                'extra' => 'La frecuencia fina se ve en el monitoreo: si la curva cae con el cielo limpio, toca lavar. No se vende un sistema sellado que nadie pueda pisar ni alcanzar.',
            ],
        ],
    ],
    'vallenar' => [
        'slug' => 'vallenar',
        'nivel' => 'principal',
        'lastmod' => '2026-11-20',
        'hsp' => 6.2,
        'kwh_precio' => 266,
        'factor_perdidas' => 0.84,
        'casos' => [
  0 => 
  [
    'titulo' => 'Riego de olivos hacia Alto del Carmen',
    'texto' => 'Bombeo solar a estanque para riego diurno del Huasco.',
    'resultado' => 'Saca el diésel de las horas de sol; el estanque hace de reserva.',
  ],
  1 => 
  [
    'titulo' => 'Casa urbana en Vallenar',
    'texto' => 'On-grid con TE4 sobre boleta de verano.',
    'resultado' => 'Ahorro diurno e inyección Net Billing con techo ventilado.',
  ],
],
        'nombre' => 'Vallenar',
        'region' => 'Atacama',
        'region_larga' => 'Región de Atacama',
        'path' => '/paneles-solares-vallenar',
        'title' => 'Paneles Solares en Vallenar | Valle del Huasco',
        'description' => 'Paneles solares en Vallenar y el Valle del Huasco: bombeo agrícola, kits off-grid rurales y ahorro on-grid en la ciudad. Riego diurno y parcelas sin empalme.',
        'h1' => 'Instalación de Paneles Solares en Vallenar y el Valle del Huasco',
        'eyebrow' => 'Vallenar · Valle del Huasco',
        'lead' => 'Vallenar concentra el encargo agrícola del Huasco: olivos, uva y hortalizas que riegan de día desde pozos o canales elevados, con un generador que ya se siente en la temporada. No es el Limarí y no se copia la ficha de Ovalle. El valle es más corto, el viento entra distinto y muchos predios entre la ciudad, Alto del Carmen y la salida a Freirina todavía no tienen un empalme que justifique la espera. Ahí cabe el bombeo solar, el off-grid rural y, en el radio urbano, un on-grid para la boleta de la casa.',
        'card' => 'Riego y bombeo del Huasco, kits rurales sin empalme y casas on-grid en la ciudad.',
        'contexto_titulo' => 'El Huasco riega de día y vive lejos del medidor',
        'dolores' => [
            [
                'titulo' => 'Combustible en el riego del valle',
                'texto' => 'El costo que el agricultor quiere bajar es el litro del generador en los meses de agua, no una boleta urbana que a veces ni existe. Si el riego puede correr con sol y hay estanque, el bombeo directo es la primera opción.',
            ],
            [
                'titulo' => 'Tramos rurales sin red conveniente',
                'texto' => 'Entre Vallenar y Alto del Carmen, y hacia Freirina, hay casas de predio y parcelas donde la extensión de red no llega este año. El off-grid se calcula para habitar y para una bomba chica, con las noches de invierno incluidas.',
            ],
            [
                'titulo' => 'Ciudad chica con cuenta de verano',
                'texto' => 'En el radio urbano sí hay empalme y una boleta que sube con el calor, aunque menos extrema que la de Copiapó. El on-grid urbano es un trabajo de techo y TE4, separado del pozo del campo.',
            ],
        ],
        'nota_filtro' => 'Un predio que no puede mover ni una hora de riego al día, y que además exige respaldo total con cielo cubierto, probablemente sigue necesitando el generador. Lo decimos en la evaluación.',
        'servicios_titulo' => 'Tres encargos distintos en el Huasco',
        'servicios' => [
            [
                'titulo' => 'Bombeo solar para riego',
                'texto' => 'Arreglo dedicado a la bomba del predio, con controlador de bombeo y protecciones, empujando agua al estanque en las horas de mejor sol. El diésel queda para el respaldo, no para todos los mediodías de la temporada.',
                'puntos' => ['Agua de día', 'Estanque como reserva', 'Datos de pozo antes de la potencia'],
            ],
            [
                'titulo' => 'Kit off-grid rural',
                'texto' => 'Para casas de valle sin empalme útil. Batería para la noche, inversor y un tablero claro. Se anota leña o gas para cocina si corresponde, para no cargar al sistema eléctrico con usos que no son eléctricos.',
                'puntos' => ['Habitación real, no solo luces', 'Bomba chica aparte si el caudal lo pide', 'Sin trámite de inyección'],
            ],
            [
                'titulo' => 'On-grid en Vallenar urbano',
                'texto' => 'Casas y locales con medidor. Net Billing, TE4 y estructura bien fijada: en el valle el viento no es el de Tongoy, pero un zinc mal tomado igual se suelta. El cálculo de producción es de interior despejado, no de bahía.',
                'puntos' => ['Boleta de la ciudad', 'Medidor bidireccional', 'Techo ventilado por el calor de Atacama'],
            ],
        ],
        'zonas_titulo' => 'Dónde cambia el proyecto dentro del Huasco',
        'zonas' => [
            ['nombre' => 'Vallenar urbano', 'texto' => 'Techos de casa y comercio con red. Se parte por la boleta y por el estado del tablero. Es el único de estos cuatro sectores donde el TE4 es la regla.'],
            ['nombre' => 'Salida a Alto del Carmen', 'texto' => 'Olivos, uva y predios con pozo. El viaje de la cuadrilla se agenda con acceso claro. El encargo típico es bombeo o casa off-grid, a veces los dos y separados.'],
            ['nombre' => 'Hacia Freirina y Huasco', 'texto' => 'Tramos rurales y viento de valle abierto. Se revisa anclaje y, si el predio se acerca a la influencia costera, el herraje deja de ser el de un interior seco.'],
            ['nombre' => 'Predios del río', 'texto' => 'Bombas cortas y estanques. Si el desnivel es bajo y el riego es diurno, el sistema puede ser más chico de lo que el cliente trae pensado. También eso es un buen resultado.'],
        ],
        'proceso_titulo' => 'Cómo se trabaja un predio en Vallenar',
        'proceso_intro' => 'El Huasco tiene cielo de interior y agua agrícola, pero las distancias son de valle: una visita mal coordinada pierde el día. Por eso el formulario pregunta comuna y tipo de proyecto antes de ofrecer fecha. No se manda una cuadrilla urbana a ver un pozo sin datos.',
        'pasos' => [
            ['titulo' => 'Agua, boleta o lista de cargas', 'texto' => 'El campo trae profundidad, caudal y horas. La casa urbana trae la boleta. La parcela sin luz trae los equipos de la noche. Con eso se decide si vale el viaje.'],
            ['titulo' => 'Visita con acceso resuelto', 'texto' => 'Se confirma camino, llave del pozo y un lugar sombreado para variador o baterías. En la ciudad basta el techo y el tablero.'],
            ['titulo' => 'Propuesta separada', 'texto' => 'Si el cliente quiere casa y riego, se cotizan como sistemas que pueden partirse. Juntarlos a la fuerza deja la bomba sin agua o la casa sin noche.'],
            ['titulo' => 'Montaje y TE4 solo urbano o con red', 'texto' => 'El on-grid entra a la SEC con TE4. El bombeo aislado y el kit rural no se anuncian como Net Billing.'],
        ],
        'cierre' => 'Si el predio está en el Huasco o la casa está en Vallenar, marca la comuna y si el problema es el diésel del riego, la falta de empalme o la boleta. Son tres presupuestos distintos y el formulario existe para no mezclarlos.',
        'faqs' => [
            [
                'q' => '¿El bombeo solar sirve para olivos y uva en el Huasco?',
                'a' => 'Sirve cuando el riego puede hacerse de día y el pozo entrega un caudal estable hacia un estanque. El cultivo no cambia la física de la bomba; cambian las horas y la temporada.',
                'extra' => 'Hace falta profundidad, caudal y desnivel. Sin eso no se promete reemplazar el generador.',
            ],
            [
                'q' => '¿Instalan kits off-grid entre Vallenar y Alto del Carmen?',
                'a' => 'Sí, en casas y parcelas donde el empalme no conviene. El kit cubre la habitación y, si corresponde, una bomba chica en un circuito separado.',
                'extra' => 'Se agenda con el acceso confirmado. Un camino cortado el día de la instalación es un costo que se evita por teléfono.',
            ],
            [
                'q' => '¿Una casa en la ciudad de Vallenar puede inyectar a la red?',
                'a' => 'Sí. Con empalme se hace un on-grid, se declara el TE4 ante la SEC y la distribuidora instala el medidor bidireccional. El excedente diurno se descuenta en la boleta.',
                'extra' => 'El calor de techo de Atacama también aplica en Vallenar: el módulo va ventilado, no acostado sobre el zinc.',
            ],
            [
                'q' => '¿En qué se diferencia este proyecto del de Ovalle?',
                'a' => 'Los dos pueden ser bombeo agrícola, pero el Huasco no es el Limarí. Cambia el valle, el viento, la distancia de visita y la mezcla con casas rurales sin red camino a Alto del Carmen o Freirina.',
                'extra' => 'Por eso Vallenar tiene página propia: un texto de Ovalle con el nombre cambiado cotizaría mal el viaje y el herraje.',
            ],
            [
                'q' => '¿Puedo pedir casa y riego en el mismo formulario?',
                'a' => 'Sí. Elige el uso principal —bombeo, parcela sin luz o casa con red— y en el contacto se aclara el segundo. Si hace falta, se visitan los dos y se cotizan separados.',
                'extra' => 'Un solo inversor para todo suele quedar corto de noche o corto de agua. Separar es más claro para el predio.',
            ],
        ],
    ],
];

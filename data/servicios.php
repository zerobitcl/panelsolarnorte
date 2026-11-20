<?php
declare(strict_types=1);

if (basename($_SERVER['SCRIPT_FILENAME'] ?? '') === 'servicios.php') {
    http_response_code(403);
    exit;
}

return [
    'net-billing-chile' => [
        'slug' => 'net-billing-chile',
        'path' => '/net-billing-chile',
        'title' => 'Net Billing en Coquimbo y Atacama | Ley 20.571 y TE4',
        'description' => 'Instalación on-grid con Net Billing en Norte Chico para casas, pymes y oficinas con red CGE. Evaluación de boleta, trámite TE4 ante la SEC y cambio a medidor bidireccional.',
        'h1' => 'Net Billing en Chile para Casas y Pymes del Norte Chico',
        'eyebrow' => 'Ley 20.571 / 21.118 · TE4 · CGE',
        'lead' => 'El Net Billing sirve cuando el inmueble ya tiene empalme y la mayor parte del problema está en la boleta de día: aire acondicionado en La Serena, refrigeración en un local de Coquimbo o consumo administrativo en una pyme de Copiapó. El sistema se conecta al tablero, autoconsume primero y recién después inyecta el excedente a la red bajo la Ley 20.571, ampliada luego por la Ley 21.118 hasta 300 kW.\n\nEn Norte Chico el error típico es copiar una potencia estándar sin mirar el perfil real de consumo ni la condición local. La camanchaca de la costa no se comporta igual que el cielo despejado del Limarí o de Atacama, y tampoco vale lo mismo una casa vacía todo el día que una oficina que parte computadores y clima desde las 9. El proyecto correcto parte por doce meses de boletas, revisión del tablero y una estimación honesta del excedente que de verdad conviene inyectar.',
        'card' => 'On-grid con TE4 y medidor bidireccional para bajar la boleta CGE en casas y pymes.',
        'servicios' => [
            [
                'titulo' => 'Dimensionamiento sobre boleta real',
                'texto' => 'La potencia del sistema sale del consumo horario probable y de la boleta anual, no de llenar el techo por llenar. En La Serena y Coquimbo pesa el verano costero; en Copiapó y Vallenar pesa más el aire acondicionado y la radiación alta con calor.',
                'puntos' => ['Lectura de 12 meses de boleta', 'Priorización del consumo diurno', 'Estimación separada por comuna y tipo de uso'],
            ],
            [
                'titulo' => 'Trámite TE4 y coordinación con distribuidora',
                'texto' => 'La conexión on-grid formal requiere declaración TE4 ingresada por instalador autorizado SEC. Después viene la revisión documental y el recambio a medidor bidireccional con la distribuidora que corresponda, normalmente CGE en la zona que atendemos.',
                'puntos' => ['Declaración TE4 por instalador autorizado', 'Respaldo documental del proyecto', 'Paso a medidor bidireccional para inyección'],
            ],
            [
                'titulo' => 'Diseño de estructura y protecciones',
                'texto' => 'No se instala igual en Tongoy, Ovalle o Tierra Amarilla. La estructura, las cajas y la canalización cambian si hay salitre, polvo fino o una cubierta que acumula demasiado calor. Ese detalle es el que evita pérdidas prematuras y falsas expectativas de producción.',
                'puntos' => ['Selección de herraje según ambiente', 'Protecciones AC/DC y canalización ordenada', 'Ubicación de inversor con ventilación y acceso'],
            ],
        ],
        'proceso_titulo' => 'Cómo trabajamos un proyecto Net Billing',
        'proceso_intro' => 'El objetivo no es solo instalar paneles, sino dejar un sistema que efectivamente pueda autoconsumir bien, tramitar su TE4 sin observaciones evitables y entrar a operar con una expectativa razonable de ahorro.',
        'pasos' => [
            [
                'titulo' => 'Revisión de boleta y uso del inmueble',
                'texto' => 'Pedimos boletas, fotos del techo y una descripción del horario real de consumo. Esa etapa permite descartar proyectos sobredimensionados o cuentas demasiado bajas para justificar la inversión.',
            ],
            [
                'titulo' => 'Visita técnica y chequeo de tablero',
                'texto' => 'Se revisan sombras, estado de cubierta, espacio para inversor y capacidad del tablero. Si el tablero está fuera de estándar o saturado, se corrige antes de prometer fechas de conexión.',
            ],
            [
                'titulo' => 'Instalación y declaración TE4',
                'texto' => 'Se monta la estructura, módulos, inversor y protecciones, y luego se ingresa el TE4 con la documentación requerida. Esa parte no se improvisa ni se reemplaza con un “certificado” informal.',
            ],
            [
                'titulo' => 'Monitoreo y entrada a régimen',
                'texto' => 'Con el medidor bidireccional ya habilitado, se valida producción, autoconsumo y lectura de excedentes. Ahí recién se compara el comportamiento del sistema con la boleta futura.',
            ],
        ],
        'faqs' => [
            [
                'q' => '¿Net Billing y paneles solares son lo mismo?',
                'a' => 'No. Los paneles son el equipo; Net Billing es el régimen legal que permite inyectar excedentes a la red cuando el inmueble tiene empalme y cumple con el trámite técnico.',
                'extra' => 'Si una parcela no tiene red, no corresponde venderle Net Billing. Ahí el camino es off-grid con baterías.',
            ],
            [
                'q' => '¿Siempre conviene llenar el techo con paneles?',
                'a' => 'No. Si el consumo diurno es bajo, sobredimensionar solo aumenta excedente mal valorizado y alarga el retorno.',
                'extra' => 'En una casa ocupada recién de noche, un sistema más pequeño suele ser mejor negocio que uno gigante que inyecta casi todo el día.',
            ],
            [
                'q' => '¿Cuánto tarda el TE4 en Norte Chico?',
                'a' => 'La instalación física suele ser más rápida que la etapa administrativa. El plazo depende de que la documentación quede bien presentada y de la coordinación posterior con la distribuidora.',
                'extra' => 'Prometer conexión inmediata sin considerar SEC y medidor bidireccional no es serio.',
            ],
            [
                'q' => '¿Se puede usar Net Billing en una pyme?',
                'a' => 'Sí, especialmente cuando la pyme consume de día: cámaras de frío, oficinas, talleres, imprentas, packing chico o bodegas con horario laboral.',
                'extra' => 'En varios casos comerciales el perfil diurno calza mejor que en una casa, por eso el ahorro suele verse antes.',
            ],
            [
                'q' => '¿CGE compra la energía al mismo valor que la vende?',
                'a' => 'No. El excedente se valoriza y descuenta, pero no equivale uno a uno a todos los componentes de la tarifa final.',
                'extra' => 'Por eso el diseño se enfoca primero en autoconsumir bien antes que en prometer “boleta cero”.',
            ],
        ],
        'cierre' => 'Si el inmueble ya tiene red y la cuenta eléctrica duele sobre todo durante el día, Net Billing es el servicio correcto. El siguiente filtro es simple: boleta real, comuna y estado del tablero.',
        'lastmod' => '2026-11-20',
        'comunas_relacionadas' => ['la-serena', 'coquimbo', 'copiapo'],
    ],
    'kit-solar-off-grid-parcelas' => [
        'slug' => 'kit-solar-off-grid-parcelas',
        'path' => '/kit-solar-off-grid-parcelas',
        'title' => 'Kit Solar Off-Grid para Parcelas | Norte Chico sin Empalme',
        'description' => 'Sistemas solares con baterías para parcelas sin empalme en Coquimbo y Atacama. Diseño de autonomía real para iluminación, refrigeración, bombas chicas y vida permanente o de fin de semana.',
        'h1' => 'Kit Solar Off-Grid para Parcelas sin Empalme',
        'eyebrow' => 'Baterías · Autonomía real · Parcelas rurales',
        'lead' => 'En Norte Chico abundan las parcelas donde el proyecto inmobiliario llegó antes que la red. Hacia el Valle de Elqui, en sectores interiores de Ovalle o en salidas rurales de Copiapó y Vallenar, la factibilidad del empalme puede costar meses o directamente dejar de tener sentido económico para una vivienda de uso parcial. Ahí no sirve vender un on-grid ni un “kit universal”: hace falta un sistema off-grid bien calculado, con baterías, inversor cargador y un listado de consumos firmado en serio.\n\nLa diferencia entre una parcela habitable y una cabaña que solo prende luces está en la noche. Refrigerador, internet, bombas de presión, cámaras, portón, microondas y eventualmente aire acondicionado cambian por completo el banco de baterías. Cuando ese dato se omite, el proyecto sale barato en papel y caro en frustración. Por eso el diseño parte por la rutina real de la parcela, no por un combo de marketplace.',
        'card' => 'Parcelas sin empalme con baterías, inversor cargador y autonomía dimensionada sobre uso real.',
        'servicios' => [
            [
                'titulo' => 'Diseño de batería según rutina de uso',
                'texto' => 'No consume igual una parcela de fin de semana en Vicuña que una vivienda permanente en Monte Patria. Se separan las cargas permanentes de las ocasionales para evitar gastar de más en baterías o quedarse corto la primera noche larga.',
                'puntos' => ['Listado completo de consumos nocturnos', 'Definición de autonomía útil', 'Diferencia entre uso ocasional y residencia permanente'],
            ],
            [
                'titulo' => 'Inversor cargador y respaldo híbrido',
                'texto' => 'Un off-grid serio puede convivir con generador o futura conexión a red, pero no depende de promesas futuras para funcionar hoy. El inversor cargador se elige por potencia continua y por capacidad de partir cargas como bombas chicas o herramientas.',
                'puntos' => ['Partida de motores considerada', 'Posibilidad de respaldo con generador', 'Tablero separado y protecciones correctas'],
            ],
            [
                'titulo' => 'Estructura y montaje para polvo, calor y viento',
                'texto' => 'Las parcelas del interior no sufren lo mismo que Tongoy y las de Atacama no se mantienen igual que las de la costa serenense. El acceso de lavado, la ventilación del módulo y la ubicación de baterías en un recinto sano pesan tanto como la potencia instalada.',
                'puntos' => ['Recinto de baterías protegido', 'Estructura según clima local', 'Acceso simple para mantención y limpieza'],
            ],
        ],
        'proceso_titulo' => 'Cómo cotizamos un off-grid que sí se puede habitar',
        'proceso_intro' => 'En sistemas aislados la conversación clave no es cuántos paneles caben, sino qué pasa entre la puesta de sol y la mañana siguiente. La autonomía manda el proyecto.',
        'pasos' => [
            [
                'titulo' => 'Levantamiento de cargas reales',
                'texto' => 'Se listan equipos, horas de uso, simultaneidad y estacionalidad. Una bomba de piscina ocasional no pesa lo mismo que un refrigerador encendido todo el año.',
            ],
            [
                'titulo' => 'Visita y validación del sitio',
                'texto' => 'Se revisa superficie útil, orientación, lugar de baterías, distancias de cableado y acceso de instalación. También se confirma si habrá generador de respaldo.',
            ],
            [
                'titulo' => 'Propuesta con autonomía y límites claros',
                'texto' => 'La cotización deja explícito qué entra y qué no entra al sistema. Ese detalle evita que después aparezca un aire acondicionado o una soldadora “que total era enchufarla”.',
            ],
            [
                'titulo' => 'Montaje, prueba nocturna y entrega',
                'texto' => 'Se prueba la conmutación, el estado de carga y las protecciones, y se explica cómo usar el sistema sin castigar innecesariamente la batería.',
            ],
        ],
        'faqs' => [
            [
                'q' => '¿Un kit off-grid reemplaza al empalme?',
                'a' => 'Puede reemplazarlo para una parcela o vivienda bien dimensionada, pero no significa energía ilimitada. Tiene límites definidos por paneles, batería y hábitos de uso.',
                'extra' => 'Quien promete usar cualquier carga “como en ciudad” sin subir mucho el presupuesto está omitiendo la parte más cara del sistema.',
            ],
            [
                'q' => '¿Se puede agregar batería después?',
                'a' => 'Sí, en muchos casos, pero conviene dejarlo previsto desde el diseño inicial para no forzar el inversor ni mezclar bancos incompatibles.',
                'extra' => 'Improvisar ampliaciones termina siendo más caro que proyectarlas bien desde el inicio.',
            ],
            [
                'q' => '¿Sirve para bombas de agua?',
                'a' => 'Sí, siempre que se declare la potencia de partida, las horas de uso y si trabajará junto con otras cargas importantes.',
                'extra' => 'Una bomba chica de presión no es lo mismo que una bomba de riego o de pozo profundo. No se cotizan igual.',
            ],
            [
                'q' => '¿Qué pasa en invierno o con varios días nublados?',
                'a' => 'Por eso se define autonomía y, si hace falta, apoyo con generador. En la costa la camanchaca afecta mañanas; en interior pesa más la duración de la noche.',
                'extra' => 'La solución responsable es declarar esa condición en el diseño, no esconderla para cerrar la venta.',
            ],
            [
                'q' => '¿Conviene litio o plomo?',
                'a' => 'En la mayoría de proyectos bien usados, litio entrega mejor gestión, más ciclos y menos mantenimiento, aunque exige una inversión inicial mayor.',
                'extra' => 'La decisión se toma con perfil de uso y presupuesto, no por moda ni por la etiqueta del proveedor.',
            ],
        ],
        'cierre' => 'Si la parcela sigue dependiendo de generador o la factibilidad del empalme no cierra, el off-grid bien hecho es el camino. La clave está en declarar todas las cargas antes de hablar de precio.',
        'lastmod' => '2026-11-20',
        'comunas_relacionadas' => ['la-serena', 'ovalle', 'copiapo'],
    ],
    'bombeo-solar-agricola' => [
        'slug' => 'bombeo-solar-agricola',
        'path' => '/bombeo-solar-agricola',
        'title' => 'Bombeo Solar Agrícola | Pozos en Limarí y Huasco',
        'description' => 'Sistemas de bombeo solar para riego agrícola en Limarí y Huasco. Evaluación de pozo, altura, caudal y llenado a tranque para bajar diésel y aprovechar las horas de mejor radiación.',
        'h1' => 'Bombeo Solar Agrícola para Pozos y Tranques del Norte Chico',
        'eyebrow' => 'Pozos · Limarí · Huasco · Tranque',
        'lead' => 'En el campo el panel no se compra por discurso verde: se compra para mover agua cuando el diésel ya no da. En el Limarí y en el Huasco, muchos predios riegan justo cuando el sol más produce, así que la primera lógica no es llenar de baterías el proyecto, sino empujar agua de día hacia un tranque o directo a una línea de riego bien programada.\n\nEl punto crítico es que el bombeo agrícola no se cotiza por intuición. Profundidad del pozo, nivel dinámico, caudal sostenible, altura total hasta el punto de entrega y ventana horaria de riego definen el sistema. Sin esos datos solo se vende humo. Cuando el campo necesita sí o sí riego nocturno o respaldo duro en varios días seguidos, eso se conversa con franqueza antes de prometer el reemplazo total del generador.',
        'card' => 'Bombeo solar para pozos del Limarí y Huasco, con foco en riego diurno y llenado a tranque.',
        'servicios' => [
            [
                'titulo' => 'Evaluación hidráulica antes del arreglo solar',
                'texto' => 'La potencia fotovoltaica depende del trabajo real de la bomba. Se revisa profundidad, caudal y altura manométrica total para determinar si conviene bombeo directo, uso con variador o una solución mixta con respaldo.',
                'puntos' => ['Lectura técnica del pozo', 'Cruce entre agua requerida y ventana solar', 'Dimensionamiento sobre datos reales de campo'],
            ],
            [
                'titulo' => 'Sistema de bombeo diurno a tranque',
                'texto' => 'En muchos predios el tranque es la mejor batería: almacenar agua cuesta menos que almacenar electricidad. El arreglo solar se orienta a llenar esa reserva durante las horas de mejor radiación y estabilizar el riego posterior.',
                'puntos' => ['Aprovechamiento del mediodía solar', 'Menor dependencia de diésel', 'Diseño pensando en temporada de riego'],
            ],
            [
                'titulo' => 'Integración con la operación agrícola',
                'texto' => 'No basta con instalar equipos. El proyecto tiene que convivir con turnos de riego, filtros, tableros existentes y acceso de mantención. Si la operación del predio no se adapta al horario solar, se define dónde sigue entrando el respaldo.',
                'puntos' => ['Compatibilidad con riego existente', 'Protecciones y partida adecuadas', 'Límites del sistema dichos desde el inicio'],
            ],
        ],
        'proceso_titulo' => 'Cómo se aborda un proyecto de bombeo solar',
        'proceso_intro' => 'El orden correcto es agua primero, energía después. Cuando se parte al revés, el campo termina con paneles bonitos y el mismo problema de riego.',
        'pasos' => [
            [
                'titulo' => 'Levantamiento de datos del pozo',
                'texto' => 'Se piden profundidad, nivel dinámico, caudal, diámetro, potencia actual y objetivo de riego o llenado. Si faltan datos críticos, la visita sirve para medirlos.',
            ],
            [
                'titulo' => 'Visita a pozo, tablero y tranque',
                'texto' => 'Se revisa la bomba, el estado del tablero, distancias de tendido y si existe un tranque o estanque que haga viable el bombeo de día.',
            ],
            [
                'titulo' => 'Diseño según ventana solar útil',
                'texto' => 'La propuesta muestra cuánta agua puede mover el sistema en la temporada y en qué horario. No se resume a una potencia de paneles aislada del uso agrícola.',
            ],
            [
                'titulo' => 'Instalación, puesta en marcha y prueba de agua',
                'texto' => 'La entrega se valida con operación real de la bomba y no solo con una prueba eléctrica. Si el agua no llega como corresponde, el proyecto no está terminado.',
            ],
        ],
        'faqs' => [
            [
                'q' => '¿Hace falta batería para bombeo solar agrícola?',
                'a' => 'Muchas veces no. Si el predio puede bombear de día y almacenar agua en tranque, esa solución suele ser más simple y más rentable.',
                'extra' => 'La batería entra cuando el horario agrícola no conversa con el sol o cuando el proyecto mezcla casa y riego de una forma que hay que separar bien.',
            ],
            [
                'q' => '¿Puede reemplazar por completo al generador?',
                'a' => 'A veces sí en las horas de sol; a veces no en jornadas extendidas, turnos nocturnos o semanas críticas. Eso depende del pozo y del calendario de agua.',
                'extra' => 'Un buen proyecto define el porcentaje de reemplazo realista en vez de prometer independencia total sin datos.',
            ],
            [
                'q' => '¿Sirve para cualquier pozo?',
                'a' => 'No. Hay pozos demasiado profundos, caudales exigentes o necesidades horarias que cambian por completo la viabilidad económica del sistema.',
                'extra' => 'Por eso el formulario pide datos hidráulicos antes de la visita larga.',
            ],
            [
                'q' => '¿Trabajan solo en agricultura grande?',
                'a' => 'No. Atendemos campos medianos, predios familiares y bombeos que hoy dependen de diésel o de una red cara e inestable.',
                'extra' => 'Lo importante no es el tamaño del predio, sino la claridad del requerimiento de agua.',
            ],
            [
                'q' => '¿El mantenimiento es complejo?',
                'a' => 'No más que cualquier equipo expuesto al polvo del valle. Lo clave es acceso de lavado, revisión de conexiones y cuidado del tablero de control.',
                'extra' => 'En Atacama y sectores secos del interior, la suciedad sobre el módulo también afecta la producción si se posterga demasiado la limpieza.',
            ],
        ],
        'cierre' => 'Si el problema principal del predio es el costo del agua bombeada y no la iluminación de una casa, bombeo solar agrícola es la conversación correcta. El siguiente paso no es pedir precio: es pedir los datos del pozo.',
        'lastmod' => '2026-11-20',
        'comunas_relacionadas' => ['ovalle', 'vallenar', 'copiapo'],
    ],
    'paneles-solares-empresas' => [
        'slug' => 'paneles-solares-empresas',
        'path' => '/paneles-solares-empresas',
        'title' => 'Paneles Solares para Empresas | Pymes y Faenas del Norte Chico',
        'description' => 'Sistemas solares para pymes, bodegas, talleres, oficinas y faenas de servicio en Coquimbo y Atacama. Diseño según consumo diurno, refrigeración, clima y operación comercial.',
        'h1' => 'Paneles Solares para Empresas, Pymes y Faenas',
        'eyebrow' => 'Pymes · Faenas chicas · Consumo diurno',
        'lead' => 'Las empresas no compran paneles para “compensar” una boleta doméstica: los compran para atacar una curva de consumo que ocurre mientras el negocio está abierto. En un taller de Coquimbo, una bodega en Ovalle, una oficina climatizada en Copiapó o una planta pequeña de servicios en Vallenar, el gasto fuerte suele caer entre la mañana y la tarde. Ese horario calza mejor con la producción solar que la mayoría de las casas.\n\nLa otra diferencia es operativa. Una pyme no puede detenerse porque el tablero quedó mal ordenado, y una faena chica no tolera que el sistema ignore partidas de equipos o ambientes agresivos como salitre, polvo o temperatura alta. Por eso este servicio se centra en proyectos donde el ahorro debe convivir con continuidad operativa, estructura adecuada al entorno y un lenguaje financiero más serio que “te caben tantos paneles”.',
        'card' => 'Solar para pymes y faenas con carga de día: talleres, oficinas, bodegas y comercios.',
        'servicios' => [
            [
                'titulo' => 'Diagnóstico de consumo comercial',
                'texto' => 'Se revisa boleta, horarios de producción o atención, equipos críticos y estacionalidad del negocio. Un minimarket, una imprenta y una oficina no tienen la misma curva ni la misma lógica de ahorro.',
                'puntos' => ['Perfil de carga por horario comercial', 'Separación entre carga base y punta', 'Revisión de continuidad operativa'],
            ],
            [
                'titulo' => 'On-grid para autoconsumo empresarial',
                'texto' => 'Cuando existe red, el sistema prioriza el autoconsumo diurno y utiliza Net Billing como complemento, no como argumento principal. Esa estrategia mejora el retorno en negocios que abren mientras el sol produce.',
                'puntos' => ['TE4 y conexión formal', 'Dimensionamiento sobre operación real', 'Enfoque en autoconsumo antes que excedente'],
            ],
            [
                'titulo' => 'Soluciones para ambientes duros',
                'texto' => 'No se instala igual en una bodega de costa que en una faena interior con polvo fino. La especificación de cajas, estructura, ventilación e incluso accesos de mantención protege la inversión y evita caídas evitables de rendimiento.',
                'puntos' => ['Materiales según salitre, polvo o calor', 'Montaje compatible con operación del negocio', 'Plan de monitoreo y mantención básica'],
            ],
        ],
        'proceso_titulo' => 'Cómo evaluamos proyectos solares para empresas',
        'proceso_intro' => 'En empresas el ahorro importa, pero la continuidad operativa manda. El sistema tiene que bajar la cuenta sin transformarse en una fuente nueva de problemas.',
        'pasos' => [
            [
                'titulo' => 'Lectura del consumo y del negocio',
                'texto' => 'Se revisan boletas y se entiende qué procesos ocurren durante el día. Esa etapa define si el proyecto tiene retorno o si la operación real no conversa con solar.',
            ],
            [
                'titulo' => 'Visita técnica del sitio y del tablero',
                'texto' => 'Se inspecciona cubierta, entorno, tablero principal y restricciones de montaje. En negocios en marcha, la instalación se coordina para no cortar procesos críticos sin aviso.',
            ],
            [
                'titulo' => 'Propuesta económica y técnica',
                'texto' => 'La cotización muestra ahorro estimado, supuestos operativos y la condición ambiental que afecta herrajes, limpieza y ventilación del sistema.',
            ],
            [
                'titulo' => 'Instalación, trámite y monitoreo',
                'texto' => 'Se ejecuta el montaje, se ingresa el trámite cuando corresponde y se deja monitoreo para verificar que el comportamiento del sistema siga alineado con la operación del negocio.',
            ],
        ],
        'faqs' => [
            [
                'q' => '¿Una pyme aprovecha mejor solar que una casa?',
                'a' => 'A menudo sí, porque consume de día. Ese horario coincide con la generación y mejora el autoconsumo directo.',
                'extra' => 'En varios casos comerciales el retorno es más claro que en una vivienda vacía hasta la noche.',
            ],
            [
                'q' => '¿Sirve para faenas chicas fuera de zona urbana?',
                'a' => 'Sí, si el requerimiento está dentro del alcance del proyecto y se define con precisión. Puede ser on-grid o off-grid según exista red y según el tipo de carga.',
                'extra' => 'No atendemos plantas industriales de gran escala ni campamentos mayores; el enfoque es pyme, bodega, taller y faena de servicios.',
            ],
            [
                'q' => '¿Qué pasa si el negocio está cerca del mar?',
                'a' => 'La especificación cambia: estructura anodizada, pernería adecuada y cajas con el IP correcto. En primera línea de costa no se puede cotizar como si fuera interior.',
                'extra' => 'Ese detalle encarece algo el proyecto, pero evita corrosión temprana y paradas innecesarias.',
            ],
            [
                'q' => '¿Se puede instalar sin detener la operación?',
                'a' => 'En muchos casos sí, coordinando etapas y ventanas de intervención. Lo que no se hace es improvisar un corte sobre procesos sensibles.',
                'extra' => 'La visita técnica define esa estrategia antes de agendar la obra.',
            ],
            [
                'q' => '¿Net Billing sigue siendo útil en empresas?',
                'a' => 'Sí, pero como complemento. Lo más valioso suele ser la energía que la empresa deja de comprar en sus horas punta de operación.',
                'extra' => 'Por eso se diseña para autoconsumo inteligente, no para vivir de los excedentes.',
            ],
        ],
        'cierre' => 'Si la empresa trabaja de día y la cuenta eléctrica ya pesa en el margen, el proyecto solar tiene sentido. El siguiente filtro es entender la operación real antes de hablar de potencia instalada.',
        'lastmod' => '2026-11-20',
        'comunas_relacionadas' => ['coquimbo', 'copiapo', 'vallenar'],
    ],
];

<?php
declare(strict_types=1);

if (basename($_SERVER['SCRIPT_FILENAME'] ?? '') === 'guias.php') {
    http_response_code(403);
    exit;
}

return [
    'cuanto-cuesta-instalar-paneles-solares-norte-chico' => [
        'slug' => 'cuanto-cuesta-instalar-paneles-solares-norte-chico',
        'path' => '/guias/cuanto-cuesta-instalar-paneles-solares-norte-chico',
        'title' => 'Cuánto Cuesta Instalar Paneles Solares en Norte Chico',
        'description' => 'Guía de costos para instalar paneles solares en Coquimbo y Atacama: casas con Net Billing, parcelas off-grid y pymes con consumo diurno.',
        'h1' => 'Cuánto Cuesta Instalar Paneles Solares en Coquimbo y Atacama',
        'eyebrow' => 'Guía de precios reales · Norte Chico',
        'lead' => 'Hablar de precio solar sin decir si hay red, batería, pozo o pyme abierta todo el día no sirve. En Norte Chico el costo cambia más por el tipo de proyecto que por la comuna, aunque el ambiente costero, el polvo de Atacama y los traslados rurales también mueven la aguja.\n\nLa forma útil de mirar el presupuesto es separar cuatro escenarios: casa on-grid con Net Billing, parcela off-grid con baterías, bombeo agrícola y pyme con autoconsumo diurno. Cada uno tiene componentes y riesgos distintos.',
        'secciones' => [
            [
                'h2' => 'Qué mueve el precio de verdad',
                'p' => 'Las tres variables que más pesan son el tipo de conexión, la complejidad eléctrica y el perfil de uso. Un on-grid residencial necesita TE4 y medidor bidireccional; un off-grid necesita batería e inversor cargador; un bombeo necesita datos hidráulicos antes de hablar de potencia.',
                'lista' => ['Existencia o no de empalme', 'Cantidad de baterías o ausencia de ellas', 'Estado del tablero y de la cubierta'],
            ],
            [
                'h2' => 'Casa on-grid: dónde se va el presupuesto',
                'p' => 'En una vivienda con red, el costo suele concentrarse en módulos, inversor, estructura, protecciones y mano de obra con trámite. El error común es pagar por más paneles de los que la casa puede autoconsumir de día.',
                'lista' => ['Boleta y horario de consumo mandan el tamaño', 'El tablero puede requerir ajustes previos', 'La costa exige materiales mejores si hay salitre'],
            ],
            [
                'h2' => 'Parcela off-grid: la batería manda',
                'p' => 'En sistemas aislados, la partida grande no suele ser el panel, sino la energía que quieres guardar para la noche. Un refrigerador, una bomba de presión y un portón eléctrico cambian por completo el proyecto respecto de una cabaña ocasional.',
                'lista' => ['Autonomía útil en noches reales', 'Potencia de partida de bombas y motores', 'Espacio sano para instalar baterías'],
            ],
            [
                'h2' => 'Bombeo y pyme: retorno distinto',
                'p' => 'En bombeo agrícola el proyecto compite contra diésel y contra horarios de agua; en pyme compite contra una boleta diurna recurrente. En ambos casos el retorno puede ser mejor que en una casa, pero solo si el dato de operación es claro.',
            ],
            [
                'h2' => 'Qué pedir antes de cotizar',
                'p' => 'No pidas un valor “por panel”. Pide una evaluación con boleta, fotos, comuna y tipo de uso. Ese filtro ahorra tiempo y evita comparar proyectos que en realidad no tienen nada en común.',
            ],
        ],
        'faqs' => [
            [
                'q' => '¿Hay un precio por panel que sirva para todos?',
                'a' => 'No. Un panel es solo una pieza del sistema y no dice nada sobre inversor, estructura, protecciones, TE4 o baterías.',
            ],
            [
                'q' => '¿Las parcelas siempre salen más caras?',
                'a' => 'Sí en términos relativos, porque requieren almacenamiento y más gestión energética. Lo que ahorran es el costo y la espera del empalme cuando ese camino no conviene.',
            ],
            [
                'q' => '¿Coquimbo y Copiapó cuestan lo mismo?',
                'a' => 'No exactamente. La costa puede exigir mejor herraje por salitre y Atacama suele pedir más atención a calor, polvo y acceso de limpieza.',
            ],
        ],
        'schema_type' => 'Article',
        'how_to_steps' => [],
        'comunas_relacionadas' => ['la-serena', 'copiapo'],
        'servicio_relacionado' => 'net-billing-chile',
        'lastmod' => '2026-11-20',
    ],
    'tramite-sec-te4-paso-a-paso' => [
        'slug' => 'tramite-sec-te4-paso-a-paso',
        'path' => '/guias/tramite-sec-te4-paso-a-paso',
        'title' => 'Trámite SEC TE4 Paso a Paso para Paneles Solares',
        'description' => 'Cómo funciona el trámite TE4 para instalaciones fotovoltaicas on-grid en Chile, con foco en proyectos residenciales y pymes del Norte Chico.',
        'h1' => 'Trámite SEC TE4 Paso a Paso',
        'eyebrow' => 'HowTo · Conexión formal a red',
        'lead' => 'El TE4 es la declaración técnica que permite formalizar una instalación fotovoltaica conectada a red. No es un papel opcional ni un detalle administrativo menor: sin ese paso, un sistema on-grid no queda bien encuadrado para operar con Net Billing.\n\nEn Coquimbo y Atacama, donde gran parte de los proyectos residenciales y de pyme funcionan con distribuidora, entender este flujo evita promesas poco serias sobre plazos y puesta en servicio.',
        'secciones' => [
            [
                'h2' => 'Quién presenta el TE4',
                'p' => 'Lo presenta un instalador eléctrico autorizado, no el propietario por su cuenta. Eso importa porque la responsabilidad técnica del proyecto debe quedar respaldada.',
            ],
            [
                'h2' => 'Qué se revisa antes de declarar',
                'p' => 'Tablero, protecciones, capacidad de conexión, plano unilineal, equipos instalados y cumplimiento de la solución ejecutada. La visita técnica bien hecha reduce observaciones posteriores.',
                'lista' => ['Estado del tablero', 'Equipos y protecciones instalados', 'Documentación técnica coherente con la obra'],
            ],
            [
                'h2' => 'Qué pasa después del ingreso',
                'p' => 'Luego del ingreso del TE4, sigue la revisión y la coordinación para medidor bidireccional con la distribuidora. La instalación física puede estar lista antes que la operación formal de inyección.',
            ],
            [
                'h2' => 'Errores comunes',
                'p' => 'Prometer fechas imposibles, instalar sin revisar tablero o presentar documentación improvisada. Esos atajos terminan frenando la entrada a régimen.',
            ],
        ],
        'faqs' => [
            [
                'q' => '¿El TE4 aplica a un sistema off-grid?',
                'a' => 'No. El TE4 corresponde a instalaciones que se conectan a red.',
            ],
            [
                'q' => '¿Sin TE4 puedo inyectar igual?',
                'a' => 'No de forma correcta ni recomendable. La instalación debe seguir su proceso formal.',
            ],
            [
                'q' => '¿El propietario puede hacerlo solo?',
                'a' => 'No como regla práctica para este tipo de proyectos. Debe intervenir un instalador autorizado que respalde la solución.',
            ],
        ],
        'schema_type' => 'HowTo',
        'how_to_steps' => [
            [
                'name' => 'Reúne boletas, fotos y datos del proyecto',
                'text' => 'Antes del diseño, junta la información del consumo y del sitio para que la solución técnica no nazca incompleta.',
            ],
            [
                'name' => 'Haz la visita técnica y revisa el tablero',
                'text' => 'El instalador debe validar sombras, cubierta, protecciones y capacidad de conexión antes de cerrar la ingeniería.',
            ],
            [
                'name' => 'Instala equipos según el diseño aprobado',
                'text' => 'Módulos, inversor, protecciones y canalización deben coincidir con la solución que se declarará.',
            ],
            [
                'name' => 'Ingresa el TE4 con respaldo técnico',
                'text' => 'El instalador autorizado presenta la declaración y la documentación correspondiente ante la SEC.',
            ],
            [
                'name' => 'Coordina medidor bidireccional y puesta en servicio',
                'text' => 'Con la tramitación en curso o aprobada, se gestiona el paso siguiente con la distribuidora para operar correctamente.',
            ],
        ],
        'comunas_relacionadas' => ['la-serena', 'coquimbo'],
        'servicio_relacionado' => 'net-billing-chile',
        'lastmod' => '2026-11-20',
    ],
    'on-grid-vs-off-grid' => [
        'slug' => 'on-grid-vs-off-grid',
        'path' => '/guias/on-grid-vs-off-grid',
        'title' => 'On-Grid vs Off-Grid: Qué Conviene en Norte Chico',
        'description' => 'Comparativa entre sistemas conectados a red y sistemas aislados con baterías para casas, parcelas y pymes de Coquimbo y Atacama.',
        'h1' => 'On-Grid vs Off-Grid: Qué Sistema Conviene',
        'eyebrow' => 'Comparativa práctica · Red vs baterías',
        'lead' => 'La decisión entre on-grid y off-grid no se toma por moda ni por preferencia tecnológica. Se toma con una sola pregunta primero: ¿hay red eléctrica útil y económicamente razonable para ese inmueble?\n\nEn Norte Chico, una casa urbana de La Serena o Copiapó normalmente calza con on-grid y Net Billing. Una parcela de Monte Patria o del Valle de Elqui sin empalme realista necesita off-grid. Mezclar ambas realidades en una sola promesa comercial es la forma más rápida de cotizar mal.',
        'secciones' => [
            [
                'h2' => 'Qué es un sistema on-grid',
                'p' => 'Es un sistema conectado al tablero del inmueble y a la red, pensado para autoconsumir la energía solar mientras produce e inyectar excedentes cuando sobran.',
                'lista' => ['Requiere empalme', 'Puede usar Net Billing', 'No necesita baterías como base del proyecto'],
            ],
            [
                'h2' => 'Qué es un sistema off-grid',
                'p' => 'Es un sistema aislado que genera y almacena energía para usarla cuando no hay sol. Su variable crítica no es el excedente, sino la autonomía nocturna.',
                'lista' => ['Usa baterías', 'No depende de la red', 'Exige declarar todas las cargas'],
            ],
            [
                'h2' => 'Cuándo conviene uno u otro',
                'p' => 'On-grid conviene cuando la boleta de día duele y ya existe red. Off-grid conviene cuando el empalme no llega, se demora demasiado o no tiene sentido económico.',
            ],
            [
                'h2' => 'Errores típicos de elección',
                'p' => 'Comprar baterías donde la red ya resuelve el respaldo básico, o instalar on-grid en una parcela que sigue sin medidor. Ambos errores nacen de no mirar el caso real.',
            ],
            [
                'h2' => 'Cómo decidir bien',
                'p' => 'Parte por la comuna, el tipo de uso y la existencia de empalme. Esa triada define el 80 % de la respuesta antes de entrar en marcas o cantidad de paneles.',
            ],
        ],
        'faqs' => [
            [
                'q' => '¿Off-grid siempre es mejor porque da independencia?',
                'a' => 'No. También cuesta más y exige una disciplina de uso que no todos necesitan ni quieren asumir.',
            ],
            [
                'q' => '¿On-grid sirve si la casa consume sobre todo de noche?',
                'a' => 'Sirve menos. Puede seguir ayudando, pero el retorno baja si casi todo el uso cae fuera de la ventana solar.',
            ],
            [
                'q' => '¿Se puede migrar de off-grid a red después?',
                'a' => 'En algunos casos sí, pero conviene preverlo desde el diseño para no duplicar costos ni equipos de manera torpe.',
            ],
        ],
        'schema_type' => 'Article',
        'how_to_steps' => [],
        'comunas_relacionadas' => ['ovalle', 'copiapo'],
        'servicio_relacionado' => 'kit-solar-off-grid-parcelas',
        'lastmod' => '2026-11-20',
    ],
    'cuantos-paneles-necesito-segun-boleta' => [
        'slug' => 'cuantos-paneles-necesito-segun-boleta',
        'path' => '/guias/cuantos-paneles-necesito-segun-boleta',
        'title' => 'Cuántos Paneles Necesito Según mi Boleta',
        'description' => 'Cómo estimar cuántos paneles solares puede necesitar una casa o pyme según su boleta, horario de consumo y comuna del Norte Chico.',
        'h1' => 'Cuántos Paneles Necesito Según mi Boleta',
        'eyebrow' => 'Cálculo preliminar · Boleta y horario',
        'lead' => 'La boleta sirve para aproximar el tamaño del sistema, pero no basta por sí sola. También hay que saber cuándo ocurre el consumo y dónde está ubicado el inmueble, porque no produce igual un techo en Coquimbo costa que uno interior en Ovalle o Copiapó.\n\nLa idea correcta no es traducir pesos directo a paneles, sino entender cuánta energía quieres desplazar durante el horario solar y cuánto techo útil hay de verdad.',
        'secciones' => [
            [
                'h2' => 'Parte por los kWh, no por los pesos',
                'p' => 'La boleta tiene cargos variables y cargos que no dependen por completo del panel. Para dimensionar bien, hay que mirar consumo energético y no solo monto total.',
            ],
            [
                'h2' => 'Revisa el horario de uso',
                'p' => 'Dos inmuebles con la misma boleta pueden necesitar soluciones muy distintas. Una oficina que consume de día aprovecha mejor el sistema que una casa vacía hasta las 20:00.',
                'lista' => ['Uso de aire acondicionado o refrigeración', 'Equipos funcionando entre mañana y tarde', 'Consumo nocturno que seguirá comprándose a la red'],
            ],
            [
                'h2' => 'La comuna cambia la estimación',
                'p' => 'La costa tiene más humedad y mañanas más lentas; el interior y Atacama ofrecen perfiles más despejados, aunque el calor y el polvo también restan. El cálculo serio ajusta esa diferencia.',
            ],
            [
                'h2' => 'El techo útil manda el límite físico',
                'p' => 'Estanques, sombras, orientaciones malas y construcciones vecinas reducen la superficie efectiva. No todos los metros cuadrados del techo sirven igual.',
            ],
            [
                'h2' => 'Qué pedir para una estimación honesta',
                'p' => 'Envía boleta, fotos de cubierta, comuna y una frase clara sobre el tipo de uso. Con eso ya se puede filtrar si el caso merece visita o si todavía falta información clave.',
            ],
        ],
        'faqs' => [
            [
                'q' => '¿Se puede calcular solo con la boleta?',
                'a' => 'Solo de forma preliminar. Después hay que mirar horario de consumo, cubierta y entorno.',
            ],
            [
                'q' => '¿Más paneles siempre significan más ahorro?',
                'a' => 'No. Si el inmueble no autoconsume bien, parte de esa energía se transforma en excedente menos rentable.',
            ],
            [
                'q' => '¿Una pyme y una casa con igual boleta llevan el mismo sistema?',
                'a' => 'No necesariamente. La pyme puede tener una curva diurna mucho más favorable para solar.',
            ],
        ],
        'schema_type' => 'Article',
        'how_to_steps' => [],
        'comunas_relacionadas' => ['coquimbo', 'ovalle'],
        'servicio_relacionado' => 'paneles-solares-empresas',
        'lastmod' => '2026-11-20',
    ],
    'mantencion-paneles-solares-desierto' => [
        'slug' => 'mantencion-paneles-solares-desierto',
        'path' => '/guias/mantencion-paneles-solares-desierto',
        'title' => 'Mantención de Paneles Solares en Zonas de Desierto',
        'description' => 'Guía práctica para limpiar y mantener paneles solares en sectores polvorientos y calurosos de Atacama y del interior del Norte Chico.',
        'h1' => 'Mantención de Paneles Solares en Zonas de Desierto',
        'eyebrow' => 'HowTo · Polvo, calor y rendimiento',
        'lead' => 'En sectores secos del Norte Chico, el problema no es la falta de radiación sino lo que el polvo y el calor le hacen a esa radiación antes de convertirse en energía útil. Un módulo sucio o mal ventilado rinde menos justo donde debería brillar más.\n\nLa mantención preventiva no significa limpiar compulsivamente todas las semanas. Significa saber cuándo el polvo ya está pegando en la producción, cómo acceder al sistema sin dañarlo y qué revisar antes de que una falla pequeña se transforme en pérdida sostenida.',
        'secciones' => [
            [
                'h2' => 'Qué ensucia más en Atacama e interior',
                'p' => 'Polvo fino, viento de valle y ausencia de lluvias frecuentes. En algunos sectores el problema es gradual; en otros, después de episodios de viento la caída de producción es evidente.',
            ],
            [
                'h2' => 'Cómo limpiar sin dañar el arreglo',
                'p' => 'Se necesita acceso seguro, agua adecuada y un método que no raye el vidrio ni fuerce la estructura. Limpiar bien vale más que limpiar seguido y mal.',
                'lista' => ['Evitar apoyo directo sobre módulos', 'Usar herramientas no abrasivas', 'Trabajar con seguridad y acceso previsto'],
            ],
            [
                'h2' => 'Qué revisar además de la suciedad',
                'p' => 'Conexiones visibles, cajas expuestas, estado del herraje y ventilación del inversor. Un sistema desértico sufre no solo por polvo, también por temperatura y envejecimiento prematuro si se instaló mal.',
            ],
            [
                'h2' => 'Cuándo conviene una visita técnica',
                'p' => 'Cuando el monitoreo muestra una caída que no se explica por clima o cuando el sitio no tiene acceso seguro para limpieza simple. Forzar una mantención casera en un techo complejo sale caro.',
            ],
        ],
        'faqs' => [
            [
                'q' => '¿Cada cuánto hay que limpiar?',
                'a' => 'No existe una frecuencia universal. Depende del sitio, del polvo, del monitoreo y del acceso de limpieza que dejó el diseño.',
            ],
            [
                'q' => '¿La lluvia basta para mantenerlos?',
                'a' => 'En Atacama y sectores interiores secos, normalmente no. La lluvia útil para limpieza natural es escasa.',
            ],
            [
                'q' => '¿La suciedad realmente cambia la producción?',
                'a' => 'Sí. En zonas polvorientas puede recortar una fracción relevante del rendimiento si se la deja acumular demasiado tiempo.',
            ],
        ],
        'schema_type' => 'HowTo',
        'how_to_steps' => [
            [
                'name' => 'Revisa el monitoreo y el contexto climático',
                'text' => 'Antes de limpiar, confirma que la baja de rendimiento no se deba solo a nubosidad, estacionalidad o consumo distinto.',
            ],
            [
                'name' => 'Prepara un acceso seguro',
                'text' => 'No improvises sobre techos calientes o inclinados sin acceso previsto. La seguridad del trabajo vale más que recuperar unos kWh en una tarde.',
            ],
            [
                'name' => 'Limpia con método no abrasivo',
                'text' => 'Usa agua y herramientas aptas para no rayar el vidrio ni castigar marcos, sellos o fijaciones.',
            ],
            [
                'name' => 'Observa herrajes, cajas e inversor',
                'text' => 'Aprovecha la visita para mirar corrosión, polvo acumulado en ventilaciones y cualquier señal temprana de desgaste.',
            ],
            [
                'name' => 'Compara la producción posterior',
                'text' => 'Después de la limpieza, valida en monitoreo si la curva recuperó nivel. Ese dato sirve para fijar una mantención futura más inteligente.',
            ],
        ],
        'comunas_relacionadas' => ['copiapo', 'vallenar'],
        'servicio_relacionado' => 'paneles-solares-empresas',
        'lastmod' => '2026-11-20',
    ],
];

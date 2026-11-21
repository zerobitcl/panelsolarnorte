<?php
declare(strict_types=1);
/** @var string $preselect */
$preselect = $preselect ?? '';
$catalog = lead_catalog();
$tenant = tenant_for_comuna($preselect !== '' ? $preselect : null);
$whatsapp = $tenant['whatsapp'];
$waMap = [];
foreach (array_keys($catalog['comunas']) as $code) {
    if ($code === 'otra') {
        $waMap[$code] = preg_replace('/\D+/', '', (string) site_config()['whatsapp']) ?: '';
        continue;
    }
    $waMap[$code] = tenant_for_comuna($code)['whatsapp'];
}
$chipLabel = $preselect !== '' && isset($catalog['comunas'][$preselect])
    ? $catalog['comunas'][$preselect]
    : '';
$origenDefault = 'hero';
?>
<section class="wizard" id="precalificador" aria-labelledby="wizard-title">
  <div class="wizard-head">
    <p class="eyebrow">Evaluación sin costo · 30 segundos</p>
    <h2 id="wizard-title">Cuéntanos el proyecto</h2>
    <p id="wizard-status" class="wizard-status sr-only" aria-live="polite">Paso 1 de 3: tipo de proyecto</p>
    <ol class="steps-bar" aria-hidden="true">
      <li data-dot class="is-on"><span class="steps-num">1</span><span class="steps-label">Tipo</span></li>
      <li data-dot><span class="steps-num">2</span><span class="steps-label">Gasto</span></li>
      <li data-dot><span class="steps-num">3</span><span class="steps-label">Contacto</span></li>
    </ol>
  </div>
  <form id="form-proyecto" method="post" action="/api/lead.php" novalidate
        data-whatsapp="<?= e($whatsapp) ?>"
        data-preselect="<?= e($preselect) ?>"
        data-wa-map='<?= e(json_encode($waMap, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?: '{}') ?>'>
    <input type="hidden" name="form_ts" value="<?= e((string) time()) ?>">
    <input type="hidden" name="source_url" value="">
    <input type="hidden" name="utm_source" value="">
    <input type="hidden" name="utm_medium" value="">
    <input type="hidden" name="utm_campaign" value="">
    <input type="hidden" name="kwp_estimado" value="">
    <input type="hidden" name="ahorro_estimado" value="">
    <input type="hidden" name="origen_cta" value="<?= e($origenDefault) ?>">
    <input type="hidden" name="pagina_tipo" value="">
    <div class="hp" aria-hidden="true">
      <label for="psn_hp">Sitio web</label>
      <input id="psn_hp" name="psn_hp" type="text" tabindex="-1" autocomplete="off" value="">
    </div>

    <div class="comuna-chip-wrap" id="comuna-chip-wrap"<?= $preselect === '' ? ' hidden' : '' ?>>
      <span class="comuna-chip" id="comuna-chip"><?= e($chipLabel !== '' ? $chipLabel : 'Comuna') ?></span>
      <button type="button" class="linkish" id="comuna-edit"<?= $preselect === '' ? ' hidden' : '' ?>>Cambiar</button>
    </div>

    <label class="field" for="comuna" id="comuna-field"<?= $preselect !== '' ? ' hidden' : '' ?>>Comuna
      <select id="comuna" name="comuna">
        <option value="">Elige tu comuna</option>
        <?php foreach ($catalog['comunas'] as $code => $label): ?>
          <option value="<?= e($code) ?>" data-label="<?= e($label) ?>"<?= $preselect === $code ? ' selected' : '' ?>><?= e($label) ?></option>
        <?php endforeach; ?>
      </select>
    </label>

    <fieldset data-step data-label="tipo de proyecto">
      <legend>¿Qué necesitas resolver?</legend>
      <p class="micro">Un toque y avanzamos. Sin llamadas: te escribimos por WhatsApp.</p>
      <div class="choices choices-cards">
        <?php
        $tipoIcons = ['ongrid' => 'home', 'offgrid' => 'sun', 'bombeo' => 'drop', 'empresa' => 'building'];
        foreach ($catalog['tipos'] as $code => $label):
        ?>
          <label class="choice choice-card">
            <input type="radio" name="tipo_proyecto" value="<?= e($code) ?>" data-label="<?= e($label) ?>" data-auto>
            <span class="choice-icon"><?= icon($tipoIcons[$code] ?? 'sun') ?></span>
            <span><?= e($label) ?></span>
          </label>
        <?php endforeach; ?>
      </div>
    </fieldset>

    <fieldset data-step data-label="gasto y plazo" hidden>
      <legend>Gasto actual y plazo</legend>
      <p class="micro">Esto prioriza tu evaluación. Toma 10 segundos.</p>
      <p class="field-label" id="gasto-label">Gasto mensual en electricidad</p>
      <div class="choices choices-chips" role="radiogroup" aria-labelledby="gasto-label">
        <?php foreach ($catalog['gastos'] as $code => $label): ?>
          <label class="choice">
            <input type="radio" name="gasto_luz" value="<?= e($code) ?>" data-label="<?= e($label) ?>">
            <span><?= e($label) ?></span>
          </label>
        <?php endforeach; ?>
      </div>
      <p class="field-label" id="plazo-label">¿Para cuándo lo necesitas?</p>
      <div class="choices choices-chips" role="radiogroup" aria-labelledby="plazo-label">
        <?php foreach ($catalog['plazos'] as $code => $label): ?>
          <label class="choice">
            <input type="radio" name="plazo" value="<?= e($code) ?>" data-label="<?= e($label) ?>" data-auto-plazo>
            <span><?= e($label) ?></span>
          </label>
        <?php endforeach; ?>
      </div>
    </fieldset>

    <fieldset data-step data-label="contacto" hidden>
      <legend>¿A quién avisamos?</legend>
      <p class="micro">Sin llamadas en frío. Solo WhatsApp del instalador de tu zona.</p>
      <label class="field" for="nombre">Nombre completo
        <input id="nombre" name="nombre" type="text" autocomplete="name" maxlength="120" placeholder="María Pérez">
      </label>
      <label class="field" for="whatsapp">WhatsApp
        <input id="whatsapp" name="whatsapp" type="tel" inputmode="tel" autocomplete="tel" placeholder="+56 9 1234 5678">
        <span class="field-hint" id="wa-hint" hidden></span>
      </label>
      <details class="email-optional">
        <summary>Agregar email (opcional)</summary>
        <label class="field" for="email">Email
          <input id="email" name="email" type="email" autocomplete="email" maxlength="160" placeholder="correo@dominio.cl">
        </label>
      </details>
    </fieldset>

    <p class="form-error" id="form-error" role="alert" hidden></p>
    <div class="wizard-actions">
      <button class="btn btn-ghost" type="button" data-back hidden>Atrás</button>
      <button class="btn btn-amber" type="button" data-next>Continuar</button>
      <button class="btn btn-amber" type="submit" data-send hidden>Recibir evaluación</button>
    </div>
    <p class="fine">Sin costo. Te contacta el instalador de tu zona por WhatsApp. No es una cotización cerrada.</p>
    <p class="fine"><a href="https://wa.me/<?= e($whatsapp) ?>" data-wa-direct data-origen="wizard_skip" target="_blank" rel="noopener">Prefiero escribir ya por WhatsApp</a></p>
  </form>
  <div class="success" id="form-success" tabindex="-1" hidden>
    <p class="success-title">Recibimos tu proyecto</p>
    <p id="success-copy">El instalador de tu comuna revisará los datos y te escribirá por WhatsApp.</p>
    <div id="success-estimate" class="success-estimate" hidden></div>
    <a class="btn btn-amber" id="success-wa" href="https://wa.me/<?= e($whatsapp) ?>" target="_blank" rel="noopener">Abrir WhatsApp con el resumen</a>
    <ol class="next-steps">
      <li>Revisamos comuna, tipo de proyecto y gasto.</li>
      <li>Te escriben por WhatsApp si el caso da para visita.</li>
      <li>En la visita se confirma techo, tablero o pozo.</li>
    </ol>
  </div>
  <noscript>
    <p>Para enviar el formulario activa JavaScript, o escribe directo al WhatsApp de la zona.</p>
    <a class="btn btn-amber" href="https://wa.me/<?= e($whatsapp) ?>">Escribir por WhatsApp</a>
  </noscript>
</section>

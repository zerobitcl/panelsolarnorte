<?php
declare(strict_types=1);
/** @var string $preselect */
$preselect = $preselect ?? '';
$calcSlug = $preselect !== '' && isset(comunas()[$preselect]) ? $preselect : 'la-serena';
$params = [];
foreach (comunas() as $slug => $item) {
    if (($item['nivel'] ?? 'principal') === 'satelite' && !isset(comunas_principales()[$slug])) {
        // Include satellites in calc too
    }
    $params[$slug] = [
        'nombre' => $item['nombre'],
        'hsp' => (float) ($item['hsp'] ?? 5.5),
        'kwh_precio' => (float) ($item['kwh_precio'] ?? 265),
        'factor_perdidas' => (float) ($item['factor_perdidas'] ?? 0.82),
    ];
}
$waMap = [];
foreach (array_keys($params) as $slug) {
    $waMap[$slug] = tenant_for_comuna($slug)['whatsapp'];
}
$whatsappDigits = $waMap[$calcSlug] ?? (preg_replace('/\D+/', '', (string) site_config()['whatsapp']) ?: '');
?>
<section class="section section-alt" id="calculadora" aria-labelledby="calc-titulo" data-calc>
  <div class="wrap calc-grid">
    <div>
      <p class="eyebrow">Estimación orientativa</p>
      <h2 id="calc-titulo">Calcula tu ahorro solar en el Norte Chico</h2>
      <p class="section-lead">Mueve la boleta y elige el uso. El resultado es un rango con pérdidas locales (camanchaca, sal, calor o polvo). No es una cotización cerrada.</p>
      <ul class="checks">
        <li>Horas de sol y precio de kWh según comuna.</li>
        <li>Descuenta pérdidas reales del techo, no el dato de catálogo.</li>
        <li>Al terminar, pasa el resultado al formulario en un clic.</li>
      </ul>
    </div>
    <div class="calc-card" id="calc-root"
         data-params='<?= e(json_encode($params, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?: '{}') ?>'
         data-wa-map='<?= e(json_encode($waMap, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?: '{}') ?>'
         data-default="<?= e($calcSlug) ?>">
      <label class="field" for="calc-comuna">Comuna
        <select id="calc-comuna" name="calc_comuna">
          <?php foreach ($params as $slug => $row): ?>
            <option value="<?= e($slug) ?>"<?= $slug === $calcSlug ? ' selected' : '' ?>><?= e($row['nombre']) ?></option>
          <?php endforeach; ?>
        </select>
      </label>
      <label class="field" for="calc-uso">Tipo de uso
        <select id="calc-uso">
          <option value="casa">Casa con red (On-Grid)</option>
          <option value="empresa">Empresa / Pyme</option>
          <option value="parcela">Parcela / Off-Grid (referencia)</option>
          <option value="bombeo">Bombeo / Riego (referencia)</option>
        </select>
      </label>
      <label class="field" for="calc-boleta">Boleta mensual aproximada
        <input id="calc-boleta" type="range" min="40000" max="350000" step="5000" value="120000">
      </label>
      <p class="calc-boleta-val" id="calc-boleta-label"><?= e(format_clp(120000)) ?></p>
      <div class="calc-result" id="calc-result" aria-live="polite">
        <div class="kpi-grid calc-kpis">
          <article class="kpi"><p>Sistema sugerido</p><strong id="calc-kwp">—</strong></article>
          <article class="kpi"><p>Paneles / techo</p><strong id="calc-paneles">—</strong></article>
          <article class="kpi"><p>Ahorro anual</p><strong id="calc-ahorro">—</strong></article>
          <article class="kpi"><p>Retorno estimado</p><strong id="calc-payback">—</strong></article>
        </div>
        <p class="fine" id="calc-disclaimer">Rango orientativo. El ahorro real depende del consumo diurno, sombras y el trámite SEC.</p>
        <div class="calc-actions">
          <button type="button" class="btn btn-amber" id="calc-to-wizard">Usar este resultado en la evaluación</button>
          <a class="btn btn-ghost" id="calc-wa" href="https://wa.me/<?= e($whatsappDigits) ?>" target="_blank" rel="noopener" data-wa-direct>WhatsApp directo</a>
        </div>
      </div>
    </div>
  </div>
</section>

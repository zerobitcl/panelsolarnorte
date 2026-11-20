(function () {
  const root = document.getElementById("calc-root");
  if (!root) {
    return;
  }

  let params = {};
  let waMap = {};
  try {
    params = JSON.parse(root.getAttribute("data-params") || "{}");
  } catch (e) {
    params = {};
  }
  try {
    waMap = JSON.parse(root.getAttribute("data-wa-map") || "{}");
  } catch (e) {
    waMap = {};
  }

  const comuna = document.getElementById("calc-comuna");
  const uso = document.getElementById("calc-uso");
  const boleta = document.getElementById("calc-boleta");
  const boletaLabel = document.getElementById("calc-boleta-label");
  const toWizard = document.getElementById("calc-to-wizard");
  const wa = document.getElementById("calc-wa");

  function money(n) {
    return "$" + Math.round(n).toLocaleString("es-CL");
  }

  function estimate() {
    const slug = comuna.value;
    const p = params[slug] || { hsp: 5.5, kwh_precio: 265, factor_perdidas: 0.82 };
    const bill = Math.max(30000, Math.min(500000, Number(boleta.value) || 120000));
    const use = uso.value;
    const usoFactor = use === "empresa" ? 0.72 : use === "parcela" ? 0.45 : use === "bombeo" ? 0.55 : 0.58;
    const kwhMes = bill / Math.max(1, p.kwh_precio);
    const kwhDia = kwhMes / 30;
    let kwp = (kwhDia * usoFactor) / Math.max(0.1, p.hsp * p.factor_perdidas);
    kwp = Math.round(Math.max(1.5, Math.min(15, kwp)) * 2) / 2;
    const paneles = Math.max(3, Math.ceil((kwp * 1000) / 550));
    const m2 = Math.round(paneles * 2.4 * 10) / 10;
    const prod = kwp * p.hsp * p.factor_perdidas * 365;
    const auto = use === "empresa" ? 0.78 : use === "bombeo" ? 0.85 : use === "parcela" ? 0.4 : 0.62;
    const base = prod * auto * p.kwh_precio;
    const ahorroMin = Math.round(base * 0.85);
    const ahorroMax = Math.round(base * 1.1);
    const capex = Math.round(kwp * 950000);
    const payMin = Math.round((capex / Math.max(1, ahorroMax)) * 10) / 10;
    const payMax = Math.round((capex / Math.max(1, ahorroMin)) * 10) / 10;
    const gasto = bill < 50000 ? "menos_50" : bill <= 120000 ? "50_120" : "mas_120";
    const tipo = use === "empresa" ? "empresa" : use === "parcela" ? "offgrid" : use === "bombeo" ? "bombeo" : "ongrid";
    return { slug, kwp, paneles, m2, ahorroMin, ahorroMax, payMin, payMax, gasto, tipo, bill };
  }

  function render() {
    const r = estimate();
    boletaLabel.textContent = money(r.bill);
    document.getElementById("calc-kwp").textContent = r.kwp.toFixed(1).replace(".", ",") + " kWp";
    document.getElementById("calc-paneles").textContent = r.paneles + " · " + String(r.m2).replace(".", ",") + " m²";
    document.getElementById("calc-ahorro").textContent = money(r.ahorroMin) + " – " + money(r.ahorroMax);
    document.getElementById("calc-payback").textContent = r.payMin + " – " + r.payMax + " años";
    if (wa) {
      const number = waMap[r.slug] || (wa.href.match(/wa\.me\/(\d+)/) || [])[1] || "";
      const text = "Hola, usé la calculadora de Panel Solar Norte en " + (params[r.slug] ? params[r.slug].nombre : r.slug)
        + ". Boleta aprox " + money(r.bill) + ", sistema sugerido " + r.kwp + " kWp, ahorro anual "
        + money(r.ahorroMin) + " a " + money(r.ahorroMax) + ". ¿Me ayudan con la evaluación?";
      wa.href = "https://wa.me/" + number + "?text=" + encodeURIComponent(text);
      wa.setAttribute("data-origen", "calculadora");
    }
    return r;
  }

  function paint() {
    render();
  }

  comuna.addEventListener("change", paint);
  uso.addEventListener("change", paint);
  boleta.addEventListener("input", paint);

  if (toWizard) {
    toWizard.addEventListener("click", function () {
      const r = render();
      const form = document.getElementById("form-proyecto");
      if (!form) {
        location.hash = "#precalificador";
        return;
      }
      const sel = form.querySelector("#comuna");
      if (sel) {
        sel.value = r.slug;
        sel.dispatchEvent(new Event("change", { bubbles: true }));
      }
      // Marcar sin disparar auto-avance del wizard.
      const tipo = form.querySelector('input[name="tipo_proyecto"][value="' + r.tipo + '"]');
      if (tipo) {
        tipo.checked = true;
      }
      const gasto = form.querySelector('input[name="gasto_luz"][value="' + r.gasto + '"]');
      if (gasto) {
        gasto.checked = true;
      }
      form.elements.kwp_estimado.value = String(r.kwp);
      form.elements.ahorro_estimado.value = r.ahorroMin + "-" + r.ahorroMax;
      form.elements.origen_cta.value = "calculadora";
      // Ir a contacto (paso 3 = index 2) en silencio para no pelear con data-auto.
      if (typeof window.psnWizardGoto === "function") {
        window.psnWizardGoto(2, { silent: true });
      }
      location.hash = "#precalificador";
      form.scrollIntoView({ behavior: "smooth", block: "start" });
      try {
        localStorage.setItem("psn_wizard", JSON.stringify({
          comuna: r.slug,
          tipo_proyecto: r.tipo,
          gasto_luz: r.gasto,
          kwp_estimado: String(r.kwp),
          ahorro_estimado: r.ahorroMin + "-" + r.ahorroMax,
          origen_cta: "calculadora"
        }));
      } catch (e) {}
    });
  }

  document.querySelectorAll("[data-wa-direct]").forEach(function (link) {
    link.addEventListener("click", function () {
      const form = document.getElementById("form-proyecto");
      const comunaVal = comuna ? comuna.value : (form && form.elements.comuna ? form.elements.comuna.value : "");
      const body = JSON.stringify({
        tipo: "click",
        origen_cta: link.getAttribute("data-origen") || "whatsapp_directo",
        source_url: location.href,
        comuna: comunaVal,
        pagina_tipo: document.body.getAttribute("data-page-tipo") || "web"
      });
      if (navigator.sendBeacon) {
        navigator.sendBeacon("/api/lead.php", new Blob([body], { type: "application/json" }));
      } else {
        fetch("/api/lead.php", { method: "POST", headers: { "Content-Type": "application/json" }, body: body, keepalive: true });
      }
    });
  });

  paint();
})();

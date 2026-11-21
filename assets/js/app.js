(function () {
  const navToggle = document.querySelector(".nav-toggle");
  const nav = document.getElementById("nav-principal");
  if (navToggle && nav) {
    navToggle.addEventListener("click", function () {
      const open = nav.classList.toggle("is-open");
      navToggle.setAttribute("aria-expanded", open ? "true" : "false");
      const label = navToggle.querySelector(".sr-only");
      if (label) {
        label.textContent = open ? "Cerrar menú" : "Abrir menú";
      }
    });
    nav.querySelectorAll("a").forEach(function (link) {
      link.addEventListener("click", function () {
        nav.classList.remove("is-open");
        navToggle.setAttribute("aria-expanded", "false");
      });
    });
    document.addEventListener("keydown", function (event) {
      if (event.key === "Escape") {
        nav.classList.remove("is-open");
        navToggle.setAttribute("aria-expanded", "false");
      }
    });
  }

  document.querySelectorAll(".faq").forEach(function (item) {
    item.addEventListener("toggle", function () {
      if (!item.open) {
        return;
      }
      document.querySelectorAll(".faq").forEach(function (other) {
        if (other !== item) {
          other.open = false;
        }
      });
    });
  });

  const form = document.getElementById("form-proyecto");
  if (!form) {
    return;
  }

  const steps = Array.prototype.slice.call(form.querySelectorAll("[data-step]"));
  const status = document.getElementById("wizard-status");
  const errorBox = document.getElementById("form-error");
  const nextButton = form.querySelector("[data-next]");
  const backButton = form.querySelector("[data-back]");
  const sendButton = form.querySelector("[data-send]");
  const wizardRoot = form.closest(".wizard") || document;
  const dots = Array.prototype.slice.call(wizardRoot.querySelectorAll("[data-dot]"));
  const comunaField = document.getElementById("comuna-field");
  const chipWrap = document.getElementById("comuna-chip-wrap");
  const chip = document.getElementById("comuna-chip");
  const editComuna = document.getElementById("comuna-edit");
  const waHint = document.getElementById("wa-hint");
  let current = 0;
  let suppressAuto = false;
  const storeKey = "psn_wizard";
  const pagePreselect = form.getAttribute("data-preselect") || "";

  let waMap = {};
  try {
    waMap = JSON.parse(form.getAttribute("data-wa-map") || "{}");
  } catch (e) {
    waMap = {};
  }

  form.source_url.value = window.location.href;
  form.elements.pagina_tipo.value = document.body.getAttribute("data-page-tipo") || "web";
  const params = new URLSearchParams(window.location.search);
  ["utm_source", "utm_medium", "utm_campaign"].forEach(function (key) {
    if (form.elements[key]) {
      form.elements[key].value = params.get(key) || "";
    }
  });

  function resolveWhatsapp(slug) {
    if (slug && waMap[slug]) {
      return waMap[slug];
    }
    return form.getAttribute("data-whatsapp") || "";
  }

  function applyWhatsapp(slug) {
    const number = resolveWhatsapp(slug);
    form.setAttribute("data-whatsapp", number);
    form.querySelectorAll("[data-wa-direct]").forEach(function (link) {
      const base = "https://wa.me/" + number;
      const text = link.href.indexOf("?text=") !== -1 ? link.href.split("?text=")[1] : "";
      link.href = text ? base + "?text=" + text : base;
    });
    const successWa = document.getElementById("success-wa");
    if (successWa && number) {
      const keep = successWa.href.indexOf("?text=");
      if (keep === -1) {
        successWa.href = "https://wa.me/" + number;
      }
    }
  }

  function savePartial() {
    try {
      const data = {
        comuna: form.elements.comuna.value,
        tipo_proyecto: (form.querySelector('input[name="tipo_proyecto"]:checked') || {}).value || "",
        gasto_luz: (form.querySelector('input[name="gasto_luz"]:checked') || {}).value || "",
        plazo: (form.querySelector('input[name="plazo"]:checked') || {}).value || "",
        nombre: form.elements.nombre.value,
        whatsapp: form.elements.whatsapp.value,
        email: form.elements.email.value,
        kwp_estimado: form.elements.kwp_estimado.value,
        ahorro_estimado: form.elements.ahorro_estimado.value,
        origen_cta: form.elements.origen_cta.value
      };
      localStorage.setItem(storeKey, JSON.stringify(data));
    } catch (e) {}
  }

  function restorePartial() {
    try {
      const raw = localStorage.getItem(storeKey);
      if (!raw) {
        return;
      }
      const data = JSON.parse(raw);
      // En páginas de comuna, data-preselect manda sobre localStorage.
      if (!pagePreselect && data.comuna && form.elements.comuna) {
        form.elements.comuna.value = data.comuna;
      }
      if (data.tipo_proyecto) {
        const el = form.querySelector('input[name="tipo_proyecto"][value="' + data.tipo_proyecto + '"]');
        if (el) {
          el.checked = true;
        }
      }
      if (data.gasto_luz) {
        const el = form.querySelector('input[name="gasto_luz"][value="' + data.gasto_luz + '"]');
        if (el) {
          el.checked = true;
        }
      }
      if (data.plazo) {
        const el = form.querySelector('input[name="plazo"][value="' + data.plazo + '"]');
        if (el) {
          el.checked = true;
        }
      }
      if (data.nombre) {
        form.elements.nombre.value = data.nombre;
      }
      if (data.whatsapp) {
        form.elements.whatsapp.value = data.whatsapp;
      }
      if (data.email) {
        form.elements.email.value = data.email;
      }
      if (data.kwp_estimado) {
        form.elements.kwp_estimado.value = data.kwp_estimado;
      }
      if (data.ahorro_estimado) {
        form.elements.ahorro_estimado.value = data.ahorro_estimado;
      }
      if (data.origen_cta && !pagePreselect) {
        form.elements.origen_cta.value = data.origen_cta;
      }
      syncChip();
    } catch (e) {}
  }

  function syncChip() {
    const select = form.elements.comuna;
    const option = select.selectedOptions[0];
    const label = option && option.value ? (option.getAttribute("data-label") || option.textContent.trim()) : "";
    if (label && chip && chipWrap) {
      chip.textContent = label;
      chipWrap.hidden = false;
      if (editComuna) {
        editComuna.hidden = false;
      }
      if (comunaField && pagePreselect) {
        comunaField.hidden = true;
      }
    }
    applyWhatsapp(select.value || pagePreselect);
  }

  function showError(message, field) {
    if (!message) {
      errorBox.hidden = true;
      errorBox.textContent = "";
      return;
    }
    errorBox.hidden = false;
    errorBox.textContent = message;
    if (field && typeof field.focus === "function") {
      field.focus();
    }
  }

  function digitsPhone(value) {
    let digits = value.replace(/\D+/g, "");
    if (digits.indexOf("56") === 0) {
      digits = digits.slice(2);
    }
    return digits;
  }

  function phoneOk(value) {
    const digits = digitsPhone(value);
    return digits.length === 9 && digits.charAt(0) === "9";
  }

  function maskPhone(value) {
    let digits = value.replace(/\D+/g, "");
    if (digits.indexOf("56") === 0) {
      digits = digits.slice(2);
    }
    if (digits.charAt(0) !== "9" && digits.length > 0) {
      digits = "9" + digits.replace(/^9*/, "");
    }
    digits = digits.slice(0, 9);
    let out = "+56";
    if (digits.length > 0) {
      out += " " + digits.charAt(0);
    }
    if (digits.length > 1) {
      out += " " + digits.slice(1, Math.min(5, digits.length));
    }
    if (digits.length > 5) {
      out += " " + digits.slice(5);
    }
    return out;
  }

  function validate(index) {
    if (!form.elements.comuna.value) {
      if (comunaField) {
        comunaField.hidden = false;
      }
      showError("Elige la comuna del proyecto.", form.elements.comuna);
      return false;
    }
    if (index === 0 && !form.querySelector('input[name="tipo_proyecto"]:checked')) {
      showError("Elige el tipo de proyecto.", form.querySelector('input[name="tipo_proyecto"]'));
      return false;
    }
    if (index === 1) {
      if (!form.querySelector('input[name="gasto_luz"]:checked')) {
        showError("Indica el gasto mensual de electricidad.", form.querySelector('input[name="gasto_luz"]'));
        return false;
      }
      if (!form.querySelector('input[name="plazo"]:checked')) {
        showError("Indica el plazo.", form.querySelector('input[name="plazo"]'));
        return false;
      }
    }
    if (index === 2) {
      const nombre = form.elements.nombre;
      const nombreValor = nombre.value.trim();
      if (nombreValor.length < 3 || /\d/.test(nombreValor)) {
        showError("Escribe tu nombre completo.", nombre);
        return false;
      }
      const tel = form.elements.whatsapp;
      if (!phoneOk(tel.value)) {
        showError("Usa un WhatsApp chileno, por ejemplo +56 9 1234 5678.", tel);
        return false;
      }
      const email = form.elements.email.value.trim();
      if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        showError("El email no tiene un formato válido. Puedes dejarlo vacío.", form.elements.email);
        return false;
      }
    }
    showError("");
    return true;
  }

  function show(index) {
    current = Math.max(0, Math.min(steps.length - 1, index));
    steps.forEach(function (step, stepIndex) {
      step.hidden = stepIndex !== current;
    });
    dots.forEach(function (dot, dotIndex) {
      dot.classList.toggle("is-on", dotIndex === current);
      dot.classList.toggle("is-done", dotIndex < current);
    });
    const label = steps[current].getAttribute("data-label") || "";
    if (status) {
      status.textContent = "Paso " + (current + 1) + " de 3: " + label;
    }
    backButton.hidden = current === 0;
    const last = current === steps.length - 1;
    nextButton.hidden = last;
    sendButton.hidden = !last;
    savePartial();
  }

  window.psnWizardGoto = function (index, options) {
    if (options && options.silent) {
      suppressAuto = true;
      window.setTimeout(function () {
        suppressAuto = false;
      }, 400);
    }
    show(index);
  };

  form.addEventListener("click", function (event) {
    const next = event.target.closest("[data-next]");
    const back = event.target.closest("[data-back]");
    if (next) {
      event.preventDefault();
      if (validate(current)) {
        show(current + 1);
      }
    }
    if (back) {
      event.preventDefault();
      showError("");
      show(current - 1);
    }
  });

  form.querySelectorAll('input[name="tipo_proyecto"][data-auto]').forEach(function (input) {
    input.addEventListener("change", function () {
      if (suppressAuto) {
        return;
      }
      if (input.checked && validate(0)) {
        window.setTimeout(function () {
          if (!suppressAuto) {
            show(1);
          }
        }, 180);
      }
    });
  });

  form.querySelectorAll('input[name="plazo"][data-auto-plazo]').forEach(function (input) {
    input.addEventListener("change", function () {
      if (suppressAuto) {
        return;
      }
      if (input.checked && validate(1)) {
        window.setTimeout(function () {
          if (!suppressAuto) {
            show(2);
          }
        }, 180);
      }
    });
  });

  form.elements.comuna.addEventListener("change", function () {
    syncChip();
    savePartial();
  });

  if (editComuna) {
    editComuna.addEventListener("click", function () {
      if (comunaField) {
        comunaField.hidden = false;
      }
      form.elements.comuna.focus();
    });
  }

  form.elements.whatsapp.addEventListener("input", function () {
    form.elements.whatsapp.value = maskPhone(form.elements.whatsapp.value);
    if (waHint) {
      if (form.elements.whatsapp.value === "") {
        waHint.hidden = true;
      } else if (phoneOk(form.elements.whatsapp.value)) {
        waHint.hidden = false;
        waHint.textContent = "Número válido";
        waHint.className = "field-hint ok";
      } else {
        waHint.hidden = false;
        waHint.textContent = "Formato: +56 9 XXXX XXXX";
        waHint.className = "field-hint";
      }
    }
    savePartial();
  });

  ["nombre", "email", "gasto_luz"].forEach(function (name) {
    form.addEventListener("change", function (event) {
      if (event.target && event.target.name === name) {
        savePartial();
      }
    });
  });

  document.querySelectorAll("[data-origen-set]").forEach(function (link) {
    link.addEventListener("click", function () {
      const origen = link.getAttribute("data-origen-set");
      if (origen && form.elements.origen_cta) {
        form.elements.origen_cta.value = origen;
        savePartial();
      }
    });
  });

  form.addEventListener("submit", function (event) {
    event.preventDefault();
    if (current < steps.length - 1) {
      if (validate(current)) {
        show(current + 1);
      }
      return;
    }
    if (!validate(current)) {
      return;
    }
    const payload = {
      form_ts: form.elements.form_ts.value,
      psn_hp: form.elements.psn_hp.value,
      comuna: form.elements.comuna.value,
      tipo_proyecto: (form.querySelector('input[name="tipo_proyecto"]:checked') || {}).value || "",
      gasto_luz: (form.querySelector('input[name="gasto_luz"]:checked') || {}).value || "",
      plazo: (form.querySelector('input[name="plazo"]:checked') || {}).value || "",
      nombre: form.elements.nombre.value.trim(),
      whatsapp: form.elements.whatsapp.value.trim(),
      email: form.elements.email.value.trim(),
      source_url: form.elements.source_url.value,
      utm_source: form.elements.utm_source.value,
      utm_medium: form.elements.utm_medium.value,
      utm_campaign: form.elements.utm_campaign.value,
      kwp_estimado: form.elements.kwp_estimado.value,
      ahorro_estimado: form.elements.ahorro_estimado.value,
      origen_cta: form.elements.origen_cta.value || "hero",
      pagina_tipo: form.elements.pagina_tipo.value || "web"
    };
    sendButton.disabled = true;
    fetch("/api/lead.php", {
      method: "POST",
      headers: { "Content-Type": "application/json", "Accept": "application/json" },
      body: JSON.stringify(payload)
    })
      .then(function (response) {
        return response.json().then(function (data) {
          return { okStatus: response.ok, data: data };
        });
      })
      .then(function (result) {
        if (!result.okStatus || !result.data.ok) {
          showError((result.data && result.data.error) || "No pudimos enviar el formulario.");
          sendButton.disabled = false;
          return;
        }
        try {
          localStorage.removeItem(storeKey);
        } catch (e) {}
        const success = document.getElementById("form-success");
        const resumen = result.data.resumen;
        const number = result.data.whatsapp_destino || form.getAttribute("data-whatsapp") || "";
        if (resumen) {
          let text = "Hola, soy " + resumen.nombre + ". Completé la evaluación en Panel Solar Norte.\n\n"
            + "Comuna: " + resumen.comuna + "\n"
            + "Proyecto: " + resumen.tipo_proyecto + "\n"
            + "Gasto actual: " + resumen.gasto_luz + "\n"
            + "Plazo: " + resumen.plazo + "\n";
          if (resumen.kwp_estimado) {
            text += "Estimación calculadora: " + resumen.kwp_estimado + " kWp";
            if (resumen.ahorro_estimado) {
              text += ", ahorro " + resumen.ahorro_estimado;
            }
            text += "\n";
          }
          text += "\n¿Me confirman la visita técnica?";
          document.getElementById("success-copy").textContent = "Quedó registrada la evaluación en " + resumen.comuna + ". Si quieres adelantar, abre WhatsApp con el resumen.";
          const est = document.getElementById("success-estimate");
          if (est && resumen.kwp_estimado) {
            est.hidden = false;
            est.textContent = "Estimación orientativa: " + resumen.kwp_estimado + " kWp"
              + (resumen.ahorro_estimado ? " · ahorro anual " + resumen.ahorro_estimado : "");
          }
          if (number) {
            document.getElementById("success-wa").href = "https://wa.me/" + number + "?text=" + encodeURIComponent(text);
          }
        }
        form.hidden = true;
        success.hidden = false;
        success.focus();
      })
      .catch(function () {
        showError("No hay conexión con el servidor. Intenta de nuevo o escribe por WhatsApp.");
        sendButton.disabled = false;
      });
  });

  // Si hay preselect de página, forzar comuna antes de restaurar parciales.
  if (pagePreselect && form.elements.comuna) {
    form.elements.comuna.value = pagePreselect;
  }
  restorePartial();
  if (pagePreselect && form.elements.comuna) {
    form.elements.comuna.value = pagePreselect;
  }
  syncChip();
  show(0);
})();

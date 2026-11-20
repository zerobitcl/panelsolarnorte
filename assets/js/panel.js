(function () {
  document.querySelectorAll("[data-pct]").forEach(function (bar) {
    bar.style.width = Math.max(0, Math.min(100, Number(bar.getAttribute("data-pct")))) + "%";
  });

  const filterForm = document.querySelector(".filters");
  const tbody = document.querySelector(".leads tbody");
  if (!filterForm || !tbody) {
    return;
  }

  const emptyNote = document.getElementById("empty-leads");
  const tableWrap = document.getElementById("table-wrap");
  const scrollHint = document.getElementById("scroll-hint");
  const csrf = filterForm.getAttribute("data-csrf") || "";
  const estados = Array.prototype.map.call(
    filterForm.querySelector('select[name="estado"]').options,
    function (option) { return option.value; }
  ).filter(Boolean);

  function el(tag, className, text) {
    const node = document.createElement(tag);
    if (className) {
      node.className = className;
    }
    if (text != null) {
      node.textContent = text;
    }
    return node;
  }

  function digits(phone) {
    return String(phone || "").replace(/\D+/g, "");
  }

  function paintKpis(kpis) {
    if (!kpis) {
      return;
    }
    document.querySelectorAll("[data-kpi]").forEach(function (node) {
      const key = node.getAttribute("data-kpi");
      if (kpis[key] == null) {
        return;
      }
      if (key === "conversion" || key === "kwp_mes") {
        node.textContent = Number(kpis[key]).toFixed(1).replace(".", ",") + (key === "conversion" ? "%" : "");
      } else {
        node.textContent = String(kpis[key]);
      }
    });
  }

  function bindLeadForm(form) {
    form.addEventListener("submit", function (event) {
      event.preventDefault();
      const button = form.querySelector("button");
      const state = form.querySelector(".save-state");
      const body = {
        id: form.elements.id.value,
        estado: form.elements.estado.value,
        notas: form.elements.notas.value,
        csrf: form.elements.csrf.value
      };
      button.disabled = true;
      fetch("/api/leads-admin.php", {
        method: "POST",
        headers: { "Content-Type": "application/json", "Accept": "application/json" },
        body: JSON.stringify(body)
      })
        .then(function (response) {
          return response.json().then(function (data) {
            return { status: response.status, data: data };
          });
        })
        .then(function (result) {
          button.disabled = false;
          if (result.status === 401) {
            window.location.reload();
            return;
          }
          if (!result.data.ok) {
            state.textContent = result.data.error || "No se guardó.";
            return;
          }
          state.textContent = "Guardado";
          paintKpis(result.data.kpis);
        })
        .catch(function () {
          button.disabled = false;
          state.textContent = "Error de red. El formulario igual puede enviarse recargando.";
        });
    });
  }

  function row(lead) {
    const tr = el("tr", "estado-" + String(lead.estado || "").toLowerCase());
    const fecha = el("td");
    const date = new Date(lead.created_at);
    fecha.textContent = Number.isNaN(date.getTime())
      ? lead.created_at
      : date.toLocaleString("es-CL", { hour12: false });
    tr.appendChild(fecha);
    tr.appendChild(el("td", "", lead.comuna));

    const proyecto = el("td");
    proyecto.append(lead.tipo_proyecto, document.createElement("br"), lead.gasto_luz, document.createElement("br"), lead.plazo);
    if (lead.kwp_estimado) {
      const est = el("span", "cell-url", lead.kwp_estimado + " kWp" + (lead.ahorro_estimado ? " · " + lead.ahorro_estimado : ""));
      proyecto.append(document.createElement("br"), est);
    }
    if (lead.origen_cta) {
      proyecto.append(document.createElement("br"), el("span", "tag tag-medio", lead.origen_cta));
    }
    if (lead.source_url) {
      proyecto.append(document.createElement("br"), el("span", "cell-url", lead.source_url));
    }
    tr.appendChild(proyecto);
    const scoreCell = el("td");
    scoreCell.appendChild(el("span", "tag tag-" + String(lead.lead_score || "").toLowerCase(), lead.lead_score));
    tr.appendChild(scoreCell);

    const contact = el("td");
    contact.appendChild(el("strong", "", lead.nombre));
    contact.appendChild(document.createElement("br"));
    contact.append(lead.whatsapp);
    const phone = digits(lead.whatsapp);
    if (phone) {
      const link = el("a", "", "Abrir WhatsApp");
      const text = "Hola " + lead.nombre + ", te contacto de Panel Solar Norte por tu proyecto en " + lead.comuna + " (" + lead.tipo_proyecto + ").";
      link.href = "https://wa.me/" + phone + "?text=" + encodeURIComponent(text);
      link.target = "_blank";
      link.rel = "noopener";
      contact.appendChild(document.createElement("br"));
      contact.appendChild(link);
    }
    if (lead.email) {
      contact.appendChild(document.createElement("br"));
      contact.append(lead.email);
    }
    tr.appendChild(contact);

    const follow = el("td");
    const form = el("form", "lead-form");
    form.method = "post";
    form.action = "/panel/";
    function hidden(name, value) {
      const input = document.createElement("input");
      input.type = "hidden";
      input.name = name;
      input.value = value;
      return input;
    }
    form.append(
      hidden("action", "update"),
      hidden("csrf", csrf),
      hidden("id", String(lead.id)),
      hidden("back", window.location.pathname + window.location.search)
    );
    const select = document.createElement("select");
    select.name = "estado";
    select.id = "estado-" + lead.id;
    estados.forEach(function (estado) {
      const option = el("option", "", estado);
      option.value = estado;
      option.selected = estado === lead.estado;
      select.appendChild(option);
    });
    const notes = document.createElement("textarea");
    notes.name = "notas";
    notes.id = "notas-" + lead.id;
    notes.rows = 2;
    notes.maxLength = 1000;
    notes.placeholder = "Nota interna";
    notes.value = lead.notas || "";
    const button = el("button", "btn btn-amber btn-small", "Guardar");
    button.type = "submit";
    form.append(select, notes, button, el("span", "save-state"));
    follow.appendChild(form);
    tr.appendChild(follow);
    bindLeadForm(form);
    return tr;
  }

  function paint(leads) {
    tbody.replaceChildren();
    leads.forEach(function (lead) {
      tbody.appendChild(row(lead));
    });
    const empty = leads.length === 0;
    if (emptyNote) {
      emptyNote.hidden = !empty;
    }
    if (tableWrap) {
      tableWrap.hidden = empty;
    }
    if (scrollHint) {
      scrollHint.hidden = empty;
    }
  }

  document.querySelectorAll(".lead-form").forEach(bindLeadForm);

  filterForm.addEventListener("submit", function (event) {
    event.preventDefault();
    const query = new URLSearchParams(new FormData(filterForm));
    const target = "/api/leads-admin.php?" + query.toString();
    fetch(target, { headers: { "Accept": "application/json" } })
      .then(function (response) {
        if (response.status === 401) {
          window.location.reload();
          return null;
        }
        return response.json();
      })
      .then(function (data) {
        if (!data || !data.ok) {
          return;
        }
        paint(data.leads || []);
        paintKpis(data.kpis);
        const pageQuery = query.toString();
        window.history.replaceState({}, "", "/panel/" + (pageQuery ? "?" + pageQuery : ""));
        const exportLink = document.querySelector('a[href*="export=csv"]');
        if (exportLink) {
          exportLink.href = "/api/leads-admin.php?export=csv" + (pageQuery ? "&" + pageQuery : "");
        }
      })
      .catch(function () {
        filterForm.submit();
      });
  });
})();

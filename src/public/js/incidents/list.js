$(document).ready(() => {
  initFilters();
  setDefaultDate();
  initTooltips();
  renderIncidents();
  bindActions();
});

function initFilters() {
  // Búsqueda al cambiar cualquiera de los inputs
  $("#provinceFilter, #fromFilter, #toFilter").on("change", renderIncidents);

  // Buscar al escribir titulo y presionar Enter
  $("#titleFilter").on("keydown", (e) => {
    if (e.key === "Enter") renderIncidents();
  });

  // Si el campo queda vacío, buscar
  $("#titleFilter").on("input", function () {
    if (this.value.trim() === "") {
      renderIncidents();
    }
  });

  // Botón de lupa
  $("#searchButton").on("click", renderIncidents);
}

function setDefaultDate() {
  const now = new Date();
  const yesterday = new Date(now.getTime() - 24 * 60 * 60 * 1000);
  $("#fromFilter").val(yesterday.toISOString().substring(0, 10));
}

function renderIncidents() {
  const prov = $("#provinceFilter").val();
  const title = $("#titleFilter").val().toLowerCase();
  const from = $("#fromFilter").val();
  const to = $("#toFilter").val();

  let visibleCount = 0;
  $(".incident-row").each(function () {
    const $incidence = $(this);
    const Prov = $incidence.data("province");
    const Title = $incidence.data("title").toLowerCase();
    const Date = $incidence.data("date");

    let visible = true;
    if (title && !Title.includes(title)) visible = false;
    if (prov && Prov != prov) visible = false;
    if (from && Date < from) visible = false;
    if (to && Date > to) visible = false;

    if (visible) {
      $incidence.show();
      visibleCount++;
    } else {
      $incidence.hide();
    }
  });

  $("#resultsCount").text(`Se encontraron ${visibleCount} incidencias.`);
}

function showModal(id) {
  // Obtener datos de la incidencia
  $.getJSON("list.php", {
    action: "GET",
    incidence_id: id,
  })
    .done(function (modalHtml) {
      $("#modalBody").html(modalHtml);
      $("#btnGoToIncidencePage").attr("href", `incidence.php?id=${id}`);
      $("#incidenceModal").modal("show");
    })
    .fail(function () {
      $("#modalBody").html("<p>Error al cargar incidencia.</p>");
      $("#incidenceModal").modal("show");
    });
}

(function () {
  const toggle = document.getElementById("beautifulToggle");
  const label = document.getElementById("beautifulToggleLabel");
  const stateBadge = document.getElementById("beautifulToggleState");

  if (!toggle) return;

  function setFromToYesterday() {
    const now = new Date();
    now.setDate(now.getDate() - 1);
    const yyyy = now.getFullYear();
    const mm = String(now.getMonth() + 1).padStart(2, "0");
    const dd = String(now.getDate()).padStart(2, "0");
    const iso = `${yyyy}-${mm}-${dd}`;
    $("#fromFilter").val(iso);
  }

  function clearFrom() {
    $("#fromFilter").val("");
  }

  function updateToggleUI(checked) {
    if (checked) {
      label.classList.remove("off");
      stateBadge.textContent = "ON";
      setFromToYesterday();
    } else {
      label.classList.add("off");
      stateBadge.textContent = "OFF";
      clearFrom();
    }

    window.dispatchEvent(
      new CustomEvent("incidents:toggle", {
        detail: {
          visible: !!checked,
        },
      })
    );

    try {
      renderIncidents();
    } catch (err) {}
  }
  updateToggleUI(toggle.checked);

  toggle.addEventListener("change", (e) => updateToggleUI(e.target.checked));
})();

function initTooltips() {
  // inicializa tooltips estáticos
  const tooltipTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="tooltip"]')
  );

  tooltipTriggerList.forEach(function (tooltipTriggerEl) {
    new bootstrap.Tooltip(tooltipTriggerEl);
  });
}

function bindActions() {
  // Copiar coordenadas
  $(document).on("click", ".btn-copy-coords", function (e) {
    const $btn = $(this);
    const lat = $btn.data("lat");
    const lng = $btn.data("lng");
    const coordsText = `(${Number(lat).toFixed(6)}, ${Number(lng).toFixed(6)})`;

    navigator.clipboard
      .writeText(coordsText)
      .then(() => {
        const $icon = $btn.find("i");
        const originalHtml = $icon.prop("outerHTML");

        // Cambia icono a check
        $icon.replaceWith('<i class="bi bi-check-lg"></i>');

        // Actualiza tooltip
        const tipInstance = bootstrap.Tooltip.getInstance($btn[0]);
        if (tipInstance) {
          tipInstance.hide();
          $btn.attr("data-bs-original-title", "¡Copiado!");
          tipInstance.show();
        } else {
          // si no hay instancia, crear y mostrar
          const t = new bootstrap.Tooltip($btn[0]);
          $btn.attr("data-bs-original-title", "¡Copiado!");
          t.show();
          setTimeout(() => t.dispose(), 800);
        }

        // Restaurar tras 1.5s
        setTimeout(() => {
          $btn.find("i").replaceWith(originalHtml);
          if (tipInstance) {
            tipInstance.hide();
            $btn.attr("data-bs-original-title", "Copiar coordenadas");
          }
        }, 1500);
      })
      .catch(() => {
        alert("No fue posible copiar las coordenadas.");
      });
  });

  // Abrir modal
  $(document).on("click", ".btn-show-modal", function (e) {
    const id = $(this).data("id");
    if (!id) return;
    showModal(id);
  });
}

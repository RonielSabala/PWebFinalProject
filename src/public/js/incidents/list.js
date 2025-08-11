$(document).ready(() => {
  initFilters();
  setDefaultDate();
  initTooltips();
  renderIncidents();
  bindActions();
});

function renderIncidents() {
  const prov = $("#provinceFilter").val();
  const title = $("#titleFilter").val().toLowerCase();
  const from = $("#fromFilter").val();
  const to = $("#toFilter").val();

  let visibleCount = 0;
  $(".incidence-row").each(function () {
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
    showModal("list.php", id);
  });
}

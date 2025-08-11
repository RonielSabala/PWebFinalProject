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

function showModal(currentRoute, id) {
  // Obtener datos de la incidencia
  $.getJSON(currentRoute, {
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

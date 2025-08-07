$(document).ready(() => {
  initMap();
  initFilters();
  setDefaultDates();
  renderIncidents();
});

// Variables mapa
let mapInstance, incidentLayer;
const defaultLat = 18.7357,
  defaultLng = -70.1627,
  defaultZoom = 8;
const popup = L.popup();

function initMap() {
  mapInstance = L.map("incidents-map").setView(
    [defaultLat, defaultLng],
    defaultZoom
  );
  L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
    maxZoom: 19,
    attribution: "&copy; OpenStreetMap",
  }).addTo(mapInstance);
  incidentLayer = L.layerGroup().addTo(mapInstance);
  mapInstance.on("click", onMapClick);
}

function onMapClick(e) {
  const { lat, lng } = e.latlng;
  const coordsText = `(${lat.toFixed(6)}, ${lng.toFixed(6)})`;
  const html = `
    <div id="coords-popup" class="d-flex align-items-center gap-2">
      <span id="coords-text" class="me-2">${coordsText}</span>
      <button
        id="copy-coords"
        type="button"
        class="btn btn-sm btn-outline-secondary"
        data-bs-toggle="tooltip"
        data-bs-placement="top"
        title="Copy coordinates"
      >
        <i class="bi bi-clipboard"></i>
      </button>
    </div>
  `;

  popup.setLatLng(e.latlng).setContent(html).openOn(mapInstance);

  let hideTimeout = setTimeout(() => mapInstance.closePopup(), 3000);

  setTimeout(() => {
    const container = document.getElementById("coords-popup");
    const copyBtn = document.getElementById("copy-coords");

    if (!container || !copyBtn) return;

    // Inicializar tooltip de Bootstrap
    const tooltip = new bootstrap.Tooltip(copyBtn);

    // Cancelar cierre mientras el mouse esté encima
    container.addEventListener("mouseenter", () => {
      clearTimeout(hideTimeout);
    });

    container.addEventListener("mouseleave", () => {
      hideTimeout = setTimeout(() => mapInstance.closePopup(), 3000);
    });

    // Copiar al portapapeles con feedback de icono/texto
    copyBtn.addEventListener("click", () => {
      navigator.clipboard.writeText(coordsText).then(() => {
        // Cambiar icono a check
        copyBtn.innerHTML = `<i class="bi bi-check-lg"></i>`;

        // Actualizar tooltip
        tooltip.hide();
        copyBtn.setAttribute("data-bs-original-title", "Copied!");
        tooltip.show();

        // Restaurar tras 1.5s
        setTimeout(() => {
          copyBtn.innerHTML = `<i class="bi bi-clipboard"></i>`;
          tooltip.hide();
          copyBtn.setAttribute("data-bs-original-title", "Copy coordinates");
        }, 1500);
      });
    });
  }, 50);
}

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

function setDefaultDates() {
  const now = new Date();
  const yesterday = new Date(now.getTime() - 24 * 60 * 60 * 1000);
  $("#fromFilter").val(yesterday.toISOString().substring(0, 10));
}

function renderIncidents() {
  incidentLayer.clearLayers();
  const prov = $("#provinceFilter").val();
  const title = $("#titleFilter").val().toLowerCase();
  const from = $("#fromFilter").val();
  const to = $("#toFilter").val();

  const filtered = incidents.filter((m) => {
    return (
      (!prov || m.province_id == prov) &&
      (!title || m.title.toLowerCase().includes(title)) &&
      (!from || m.occurrence_date >= from) &&
      (!to || m.occurrence_date <= to)
    );
  });

  // Actualizar contador
  $("#resultsCount").text(`Se encontraron ${filtered.length} incidencias.`);

  // Clusterizar
  const clusters = {};
  filtered.forEach((m) => {
    const pid = m.province_id;
    if (!clusters[pid]) clusters[pid] = L.markerClusterGroup();
    const marker = L.marker([m.latitude, m.longitude]);
    marker.on("click", () => onMarkerClick(m));
    clusters[pid].addLayer(marker);
  });
  Object.values(clusters).forEach((c) => incidentLayer.addLayer(c));
}

function addMarkerToCluster(m, clusters) {
  const coords = [m.latitude, m.longitude];
  const marker = L.marker(coords);
  const pid = m.province_id;

  if (!clusters[pid]) {
    clusters[pid] = L.markerClusterGroup();
  }

  marker.on("click", () => onMarkerClick(m));
  clusters[pid].addLayer(marker);
}

function onMarkerClick(m) {
  // Datos de la incidencia
  let modalHtml = `
    <p><strong>Título:</strong> ${m.title}</p>
    <p><strong>Descripción:</strong> ${m.incidence_description}</p>
    <p><strong>Fecha y Hora:</strong> ${m.occurrence_date}</p>
    <p><strong>Muertos:</strong> ${m.n_deaths}</p>
    <p><strong>Heridos:</strong> ${m.n_injured}</p>
    <p><strong>Pérdidas:</strong> RD$${m.n_losses}</p>
    <hr>
    <p class="text-center"><strong>Comentarios</strong></p>
    <div id="modalComments">Cargando comentarios...</div>
  `;

  $("#modalBody").html(modalHtml);
  $("#incidenceModal").modal("show");

  // Obtener comentarios de la incidencia
  $.getJSON("map.php", {
    action: "GET",
    incidence_id: m.id,
  })
    .done(function (comments) {
      let commentsHtml;
      if (Array.isArray(comments) && comments.length > 0) {
        commentsHtml = comments
          .map(
            (c) =>
              `<p><strong>${c.creation_date}</strong> ${c.username}: ${c.comment_text}</p>`
          )
          .join("");
      } else {
        commentsHtml = "<p>No hay comentarios...</p>";
      }

      $("#modalComments").html(commentsHtml);
    })
    .fail(function () {
      $("#modalComments").html("<p>Error al cargar comentarios.</p>");
    });
}

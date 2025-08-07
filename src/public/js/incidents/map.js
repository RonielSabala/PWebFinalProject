$(document).ready(() => {
  initMap();
  initFilters();
  renderIncidents();
});

// Variables
let mapInstance;
let incidentLayer;
const popup = L.popup();

// Posición inicial del mapa
const defaultLat = 18.7357;
const defaultLng = -70.1627;
const defaultZoom = 8;

// Funciones

function initMap() {
  // Crear mapa y capa de marcadores
  mapInstance = L.map("incidents-map").setView(
    [defaultLat, defaultLng],
    defaultZoom
  );

  // Crear capa de marcadores
  L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
    maxZoom: 19,
    attribution: "&copy; OpenStreetMap",
  }).addTo(mapInstance);

  incidentLayer = L.layerGroup().addTo(mapInstance);

  // Click sobre el mapa para ver coordenadas
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
  $("#provinceFilter, #titleFilter, #fromFilter, #toFilter").on(
    "input change",
    renderIncidents
  );
}

function renderIncidents() {
  incidentLayer.clearLayers();

  const provFilter = $("#provinceFilter").val().toLowerCase();
  const titleFilter = $("#titleFilter").val().toLowerCase();
  const fromDate = $("#fromFilter").val();
  const toDate = $("#toFilter").val();

  // Filtramos según provincia, título y fecha
  const filtered = incidents.filter((m) => {
    const date = m.occurrence_date;
    const okProv = !provFilter || String(m.province_id) === provFilter;
    const okTitle = !titleFilter || m.title.toLowerCase().includes(titleFilter);
    const okDate =
      (!fromDate || date >= fromDate) && (!toDate || date <= toDate);
    return okProv && okTitle && okDate;
  });

  // Agrupar en clusters por provincia
  const clusters = {};
  filtered.forEach((m) => addMarkerToCluster(m, clusters));

  // Añadir todos los clusters al mapa
  Object.values(clusters).forEach((cluster) => incidentLayer.addLayer(cluster));
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
  // Mostrar datos del incidente en el modal
  let html = `
    <p><strong>Título:</strong> ${m.title}</p>
    <p><strong>Descripción:</strong> ${m.incidence_description}</p>
    <p><strong>Fecha y Hora:</strong> ${m.occurrence_date}</p>
    <p><strong>Muertos:</strong> ${m.n_deaths}</p>
    <p><strong>Heridos:</strong> ${m.n_injured}</p>
    <p><strong>Pérdidas:</strong> RD$${m.n_losses}</p>
    <hr>
    <p class="text-center"><strong>Comentarios</strong></p>
    <div id="comments-loading">Cargando comentarios...</div>
    <div id="comments-list"></div>
  `;
  $("#modalBody").html(html);
  $("#incidenceModal").modal("show");

  // Obtener comentarios
  $.getJSON("map.php", {
    action: "GET",
    incidence_id: m.id,
  })
    .done(function (comments) {
      $("#comments-loading").remove();
      if (Array.isArray(comments) && comments.length > 0) {
        $("#comments-list").html(
          comments
            .map(
              (c) =>
                `<p><strong>${c.creation_date}</strong> ${c.username}: ${c.comment_text}</p>`
            )
            .join("")
        );
      } else {
        $("#comments-list").html("<p>No hay comentarios...</p>");
      }
    })
    .fail(function () {
      $("#comments-loading").text("Error al cargar comentarios.");
    });
}

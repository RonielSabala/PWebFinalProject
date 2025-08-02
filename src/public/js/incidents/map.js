$(document).ready(() => {
  initMap();
  initFilters();
  renderIncidents();
  initModalWithComments();
});

// Variables
let mapInstance;
let incidentLayer;
const popup = L.popup();

// Datos preestablecidos de la posición inicial del mapa
const defaultLat = 18.7357;
const defaultLng = -70.1627;
const defaultZoom = 8;

// Obtener los datos de la posición inicial del mapa
const urlParams = new URLSearchParams(window.location.search);
const savedLat = parseFloat(urlParams.get("lat"));
const savedLng = parseFloat(urlParams.get("lng"));
const savedZoom = parseInt(urlParams.get("zoom"), 10);

// Funciones

function initMap() {
  // Crear mapa y capa de marcadores
  const viewLat = !isNaN(savedLat) ? savedLat : defaultLat;
  const viewLng = !isNaN(savedLng) ? savedLng : defaultLng;
  const viewZoom = !isNaN(savedZoom) ? savedZoom : defaultZoom;
  mapInstance = L.map("incidents-map").setView([viewLat, viewLng], viewZoom);

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
  popup
    .setLatLng(e.latlng)
    .setContent(`Coordenadas: ${e.latlng.toString()}`)
    .openOn(mapInstance);
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

// Handlers

function onMarkerClick(m) {
  // Redirigir para obtener comentarios via PHP

  const zoom = mapInstance.getZoom();
  const center = mapInstance.getCenter();
  window.location.href =
    `map.php?action=showModal&incidence_id=${encodeURIComponent(m.id)}` +
    `&lat=${center.lat}&lng=${center.lng}&zoom=${zoom}`;
}

function initModalWithComments() {
  const m = incidents.find((x) => x.id === initialIncidence);
  if (!m) return;

  let html = `
      <p><strong>Título:</strong> ${m.title}</p>
      <p><strong>Descripción:</strong> ${m.incidence_description}</p>
      <p><strong>Fecha y Hora:</strong> ${m.occurrence_date}</p>
      <p><strong>Muertos:</strong> ${m.n_deaths}</p>
      <p><strong>Heridos:</strong> ${m.n_injured}</p>
      <p><strong>Pérdidas:</strong> RD$${m.n_losses}</p>
      <hr>
      <p class="text-center"><strong>Comentarios</strong></p>
  `;

  if (!Array.isArray(initialComments) || initialComments.length === 0) {
    html += "<p>No hay comentarios...</p>";
  } else {
    html += initialComments
      .map(
        (c) =>
          `<p><strong>${c.creation_date}</strong> ${c.username}: ${c.comment_text}</p>`
      )
      .join("");
  }

  $("#modalBody").html(html);
  $("#incidenceModal").modal("show");
}

// Limpia los parámetros GET al cerrar el modal
document
  .getElementById("incidenceModal")
  .addEventListener("hidden.bs.modal", () => {
    const cleanUrl = window.location.origin + window.location.pathname;
    history.replaceState(null, "", cleanUrl);
  });

$(document).ready(() => {
  initMap();
  initFilters();
  setDefaultDate();
  renderIncidents();
});

(function () {
  // Evitar ejecutar más de una vez
  if (window.__list_init_done) return;

  function runInit() {
    if (window.__list_init_done) return;
    window.__list_init_done = true;
    initMap();
    initFilters();
    setDefaultDate();
    renderIncidents();
  }

  function checkAndRun() {
    if (document.getElementById("initialize-scripts")) {
      runInit();
      return true;
    }
    return false;
  }

  // Si ya existe, ejecutar inmediatamente
  if (checkAndRun()) return;

  // Si el DOM aún no está listo, esperar a DOMContentLoaded y luego observar
  function startObserver() {
    const target = document.documentElement || document.body;
    if (!target) return;

    const observer = new MutationObserver((mutations, obs) => {
      if (checkAndRun()) {
        obs.disconnect();
      }
    });

    observer.observe(target, { childList: true, subtree: true });
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", () => {
      if (!checkAndRun()) startObserver();
    });
  } else {
    // DOM ya cargado pero elemento no presente: observar inserciones
    startObserver();
  }
})();

// Variables del mapa
let mapInstance, incidenceLayer;
const defaultLat = 18.7357,
  defaultLng = -70.1627,
  defaultZoom = 8;
const popup = L.popup();

// Icono por defecto
const defaultIconUrl = "https://cdn-icons-png.flaticon.com/512/684/684908.png";

function getMarker(m) {
  // Obtener icono
  let icon_url = m.label_icons;
  if (!icon_url || !icon_url.trim()) {
    icon_url = defaultIconUrl;
  } else {
    const parts = icon_url
      .split(",")
      .map((p) => p.trim())
      .filter(Boolean);

    icon_url = parts[0];
  }

  let icon = L.icon({
    iconUrl: icon_url,
    iconSize: [40, 40],
    iconAnchor: [16, 32],
    popupAnchor: [0, -32],
  });

  // Devolver marcador
  return L.marker([m.latitude, m.longitude], {
    icon: icon,
  });
}

function initMap() {
  // Evitar que clicks en overlay lleguen al mapa
  const overlay = document.getElementById("search-bar-container");
  L.DomEvent.disableClickPropagation(overlay);
  L.DomEvent.disableScrollPropagation(overlay);

  mapInstance = L.map("incidents-map", { zoomControl: false }).setView(
    [defaultLat, defaultLng],
    defaultZoom
  );

  L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
    maxZoom: 19,
  }).addTo(mapInstance);
  incidenceLayer = L.layerGroup().addTo(mapInstance);
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
        title="Copiar coordenadas"
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
        copyBtn.setAttribute("data-bs-original-title", "¡Copiado!");
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

function renderIncidents() {
  incidenceLayer.clearLayers();
  const prov = $("#provinceFilter").val();
  const title = $("#titleFilter").val().toLowerCase();
  const from = $("#fromFilter").val();
  const to = $("#toFilter").val();
  const label = $("#labelFilter").val();

  const filtered = incidents.filter((incidence) => {
    return (
      (!title || incidence.title.toLowerCase().includes(title)) &&
      (!prov || incidence.province_id == prov) &&
      (!from || incidence.creation_date >= from) &&
      (!to || incidence.creation_date <= to) &&
      (!label || incidence.labels[0] == label)
    );
  });

  $("#resultsCount").text(`Se encontraron ${filtered.length} incidencias.`);

// Cluster de todas las incidencias
const clusterGroup = L.markerClusterGroup({
  showCoverageOnHover: false,
});

filtered.forEach((m) => {
  const marker = getMarker(m);
  marker.on("click", () => showModal("map.php", m.id));
  clusterGroup.addLayer(marker);
});

incidenceLayer.addLayer(clusterGroup);

function addMarkerToCluster(m, clusterGroup) {
  const marker = getMarker(m);
  marker.on("click", () => showModal("map.php", m.id));
  clusterGroup.addLayer(marker);
}}

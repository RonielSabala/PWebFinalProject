$(document).ready(() => {
  initMap();
  initFilters();
  setDefaultDate();
  renderIncidents();
});

// Variables mapa
let mapInstance, incidentLayer;
const defaultLat = 18.7357,
  defaultLng = -70.1627,
  defaultZoom = 8;
const popup = L.popup();

// Iconos para los marcadores
const labelIcons = {
  "Accidente de tráfico": L.icon({
    iconUrl: "https://cdn-icons-png.flaticon.com/512/4939/4939159.png",
    iconSize: [40, 40],
    iconAnchor: [16, 32],
    popupAnchor: [0, -32],
  }),
  Robo: L.icon({
    iconUrl: "https://cdn-icons-png.flaticon.com/512/5138/5138771.png",
    iconSize: [32, 32],
    iconAnchor: [16, 32],
    popupAnchor: [0, -32],
  }),
  Incendio: L.icon({
    iconUrl: "https://cdn-icons-png.flaticon.com/512/599/599502.png",
    iconSize: [32, 32],
    iconAnchor: [16, 32],
    popupAnchor: [0, -32],
  }),
  Inundación: L.icon({
    iconUrl: "https://cdn-icons-png.flaticon.com/512/3436/3436914.png",
    iconSize: [40, 40],
    iconAnchor: [16, 32],
    popupAnchor: [0, -32],
  }),
  Asesinato: L.icon({
    iconUrl: "https://cdn-icons-png.flaticon.com/512/2323/2323041.png",
    iconSize: [32, 32],
    iconAnchor: [16, 32],
    popupAnchor: [0, -32],
  }),
  Violencia: L.icon({
    iconUrl: "https://cdn-icons-png.flaticon.com/512/10554/10554358.png",
    iconSize: [40, 40],
    iconAnchor: [16, 32],
    popupAnchor: [0, -32],
  }),
  "Desastre natural": L.icon({
    iconUrl: "https://cdn-icons-png.flaticon.com/512/13063/13063838.png",
    iconSize: [40, 40],
    iconAnchor: [16, 32],
    popupAnchor: [0, -32],
  }),
};

// Icono por defecto
const defaultIcon = L.icon({
  iconUrl: "https://cdn-icons-png.flaticon.com/512/684/684908.png",
  iconSize: [32, 32],
  iconAnchor: [16, 32],
  popupAnchor: [0, -32],
});

function getIconByLabel(label) {
  if (!label) return defaultIcon;
  const key = label.trim();
  return labelIcons[key] || defaultIcon;
}

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

function setDefaultDate() {
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
      (!title || (m.title && m.title.toLowerCase().includes(title))) &&
      (!from || m.creation_date >= from) &&
      (!to || m.creation_date <= to)
    );
  });

  $("#resultsCount").text(`Se encontraron ${filtered.length} incidencias.`);

  const clusters = {};
  filtered.forEach((m) => {
    const pid = m.province_id || "noprov";
    if (!clusters[pid]) clusters[pid] = L.markerClusterGroup();

    // INTENTA obtener label: si m.labels es array usa [0], si es string usa directamente
    let labelVal = null;
    if (Array.isArray(m.labels)) labelVal = m.labels[0];
    else if (typeof m.labels === "string") labelVal = m.labels;
    // else si tienes otro campo: m.label o m.type, ajusta aquí

    const icon = getIconByLabel(labelVal);
    const marker = L.marker([m.latitude, m.longitude], { icon });
    marker.on("click", () => onMarkerClick(m));
    clusters[pid].addLayer(marker);
  });

  Object.values(clusters).forEach((c) => incidentLayer.addLayer(c));
}

function addMarkerToCluster(m, clusters) {
  const coords = [m.latitude, m.longitude];
  const icon = getIconByLabel(m.labels?.[0]);
  const marker = L.marker(coords, { icon: icon });
  const pid = m.province_id;

  if (!clusters[pid]) {
    clusters[pid] = L.markerClusterGroup();
  }

  marker.on("click", () => onMarkerClick(m));
  clusters[pid].addLayer(marker);
}

function onMarkerClick(m) {
  // Obtener datos de la incidencia
  $.getJSON("map.php", {
    action: "GET",
    incidence_id: m.id,
  })
    .done(function (modalHtml) {
      $("#modalBody").html(modalHtml);
      $("#btnGoToIncidencePage").attr("href", `incidence.php?id=${m.id}`);
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

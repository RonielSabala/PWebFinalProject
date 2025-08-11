$(document).ready(() => {
  initMap();
  initFilters();
  setDefaultDate();
  renderIncidents();
});

// Variables del mapa
let mapInstance, incidentLayer;
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
    if (!clusters[m.province_id])
      clusters[m.province_id] = L.markerClusterGroup();

    const marker = getMarker(m);
    marker.on("click", () => onMarkerClick(m));
    clusters[m.province_id].addLayer(marker);
  });

  Object.values(clusters).forEach((c) => incidentLayer.addLayer(c));
}

function addMarkerToCluster(m, clusters) {
  if (!clusters[m.province_id]) {
    clusters[m.province_id] = L.markerClusterGroup();
  }

  const marker = getMarker(m);
  marker.on("click", () => onMarkerClick(m));
  clusters[m.province_id].addLayer(marker);
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

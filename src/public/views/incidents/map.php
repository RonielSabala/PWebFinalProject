<!-- Estilos del mapa -->
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.Default.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

<div class="centered container">
    <!-- Buscador principal -->
    <div class="search-bar-container">
        <div class="search-bar">
            <input type="text" id="titleFilter" class="form-control" placeholder="Buscar por título…" />
            <select id="provinceFilter" class="form-select">
                <option value="">Todas</option>
                <?php foreach ($provinces as $prov): ?>
                    <option value="<?= $prov['id'] ?>"><?= $prov['province_name'] ?></option>
                <?php endforeach; ?>
            </select>
            <input type="date" id="fromFilter" class="form-control" />
            <input type="date" id="toFilter" class="form-control" />
            <button id="searchButton" class="btn btn-outline-secondary">
                <i class="bi bi-search"></i>
            </button>
        </div>
    </div>

    <!-- Contador de resultados -->
    <div id="resultsCount">Cargando...</div>

    <!-- Mapa -->
    <div id="incidents-map"></div>

    <!-- Modal -->
    <div class="modal fade" id="incidenceModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Header -->
                <div class="modal-header">
                    <h5 class="modal-title">Detalles de incidencia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <!-- Contenido -->
                <div class="modal-body" id="modalBody"></div>

                <!-- Footer -->
                <div class="modal-footer">
                    <a id="btnGoToIncidencePage" class="btn btn-primary me-auto" href="#" target="_blank" rel="noopener noreferrer">Abrir en otra página</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts del mapa -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script src="https://unpkg.com/leaflet.markercluster/dist/leaflet.markercluster.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const incidents = <?= json_encode($incidents) ?>;
</script>
<!-- Estilos del mapa -->
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.Default.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

<!-- Scripts necesarios para el mapa -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script src="https://unpkg.com/leaflet.markercluster/dist/leaflet.markercluster.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Contenido -->
<div class="centered">
    <!-- Filtros para buscar incidencias -->
    <div class="container mb-3">
        <div class="row g-2">
            <!-- Campo provincia -->
            <div class="col-md-3">
                <label>Provincia</label>
                <select id="provinceFilter" class="form-select">
                    <option value="">Todas</option>
                    <?php
                    foreach ($provinces as $prov) {
                        echo "<option value='{$prov['id']}'>{$prov['province_name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <!-- Campo título -->
            <div class="col-md-3">
                <label>Título</label>
                <input type="text" id="titleFilter" class="form-control" placeholder="Buscar por título">
            </div>
            <!-- Campo desde -->
            <div class="col-md-3">
                <label>Desde</label>
                <input type="date" id="fromFilter" class="form-control">
            </div>
            <!-- Campo hasta -->
            <div class="col-md-3">
                <label>Hasta</label>
                <input type="date" id="toFilter" class="form-control">
            </div>
        </div>
    </div>
    <div id="incidents-map">
        <!-- Aquí va el mapa -->
    </div>
    <div class="modal fade" id="incidenceModal" tabindex="-1" aria-labelledby="incidenceModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="incidenceModalLabel">Detalles de incidencia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body" id="modalBody">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const incidents = <?= json_encode($incidents) ?>;
    const initialComments = <?= json_encode($comments) ?>;
    const initialIncidence = Number(<?= json_encode($incidence_id) ?>);
</script>
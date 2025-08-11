<!-- Estilos del mapa-->
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.Default.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<?php include_once('_partials/__header.php'); ?>

<!-- Botón para ir a la lista -->
<div class="d-flex justify-content-between align-items-center mb-3">
    <a href="list.php" class="btn btn-primary btn rounded-pill d-flex align-items-center gap-2 shadow-sm">
        <i class="bi bi-list-ul fs-5"></i>
        <span class="fw-semibold">Ver en Lista</span>
    </a>
</div>

<!-- Mapa de incidencias -->
<div id="incidents-map"></div>

<?php include_once('_partials/__footer.php'); ?>

<!-- Scripts del mapa -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script src="https://unpkg.com/leaflet.markercluster/dist/leaflet.markercluster.js"></script>
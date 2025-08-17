<h2 class="dashboard-title">Bienvenido</h2>
<p class="dashboard-subtitle">Accede rápido a las incidencias y consulta la información más reciente.</p>

<!-- Accesos rápidos con métricas -->
<div class="quick-access d-flex flex-wrap gap-4">
    <div class="card-dashboard flex-fill">
        <i class="bi bi-map card-icon"></i>
        <h3>Mapa de incidencias</h3>
        <p>Explora las incidencias registradas en un mapa interactivo.</p>
        <a href="incidents/map.php" class="btn btn-dashboard">Ir al mapa</a>
    </div>

    <div class="card-dashboard flex-fill">
        <i class="bi bi-list-ul card-icon"></i>
        <h3>Lista de incidencias</h3>
        <p>Consulta el listado completo de incidencias registradas.</p>
        <a href="incidents/list.php" class="btn btn-dashboard">Ver lista</a>
    </div>
</div>

<!-- Sección informativa -->
<section class="project-info mt-5">
    <h2>Sobre la plataforma</h2>
    <p>
        Esta página web permite registrar, visualizar y gestionar incidencias ocurridas en el país,
        utilizando mapas, formularios y autenticación de usuarios.
    </p>

    <div class="features">
        <div class="feature-item">
            <img src="../imgs/traffic_accident.jpeg" alt="Accidente de Tráfico">
            <h4>Registro de Incidencias</h4>
            <p>Registra fecha, tipo, ubicación, víctimas, pérdida estimada y foto del hecho.</p>
        </div>

        <div class="feature-item">
            <img src="../imgs/mapa.jpeg" alt="Mapa Interactivo">
            <h4>Visualización en el Mapa</h4>
            <p>Consulta incidencias recientes en un mapa interactivo con íconos según tipo y clustering.</p>
        </div>

        <div class="feature-item">
            <img src="../imgs/robo.jpeg" alt="Robo">
            <h4>Vista en Lista</h4>
            <p>Revisa todas las incidencias registradas en un listado completo con detalles.</p>
        </div>

        <div class="feature-item">
            <img src="../imgs/incendio.jpeg" alt="Incendio">
            <h4>Filtros y Búsqueda</h4>
            <p>Filtra por provincia, tipo de incidencia, rango de fecha o busca por título.</p>
        </div>
    </div>
</section>
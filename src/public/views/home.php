<div class="container-max">

    <!-- HERO -->
    <section class="hero-overlay">
        <img src="../imgs/home/front_page.jpg" alt="Fondo ilustrativo" loading="lazy" />
        <div class="hero-content">
            <h1 class="display-1">Incidencias RD</h1>
            <h2 class="display-5">¡En donde todo pasa!</h2>
            <p>
                Visualiza las incidencias mas recientes en el país, crea comentarios y sugiere cambios para mantener las incidencias actualizadas.
            </p>
        </div>
    </section>

    <!-- Quick access + métricas -->
    <section>
        <h2 lass="mb-3">Accesos rápidos</h2>

        <div class="quick-access">
            <article class="card-dashboard">
                <div class="card-top">
                    <span class="card-icon"><i class="bi bi-map"></i></span>
                    <div>
                        <h3>Mapa de incidencias</h3>
                        <p class="muted">Explora las incidencias en un mapa interactivo.</p>
                    </div>
                </div>

                <div class="stat-row">
                    <div>
                        <div class="stat-number"><?= $incidentsCount ?></div>
                        <div class="muted" style="font-weight:600;">incidencias totales</div>
                    </div>
                    <div style="text-align:right;">
                        <small class="muted">Pendientes: <strong><?= $pendingIncidentsCount ?></strong></small>
                    </div>
                </div>

                <div class="card-actions">
                    <a href="incidents/map.php" class="btn-dashboard">Ir al mapa</a>
                </div>
            </article>

            <article class="card-dashboard">
                <div class="card-top">
                    <span class="card-icon"><i class="bi bi-list-ul"></i></span>
                    <div>
                        <h3>Lista de incidencias</h3>
                        <p class="muted">Listado completo y paginado con búsqueda por texto y filtros avanzados.</p>
                    </div>
                </div>

                <div class="stat-row">
                    <div>
                        <div class="stat-number"><?= $recentIncidentsCount ?></div>
                        <div class="muted" style="font-weight:600;">incidencias recientes (24h)</div>
                    </div>
                    <div style="text-align:right;">
                        <small class="muted">Última: <strong><?= $lastIncidenceDate ?></strong></small>
                    </div>
                </div>

                <div class="card-actions">
                    <a href="incidents/list.php" class="btn-dashboard">Ver lista</a>
                </div>
            </article>
        </div>
    </section>

    <!-- Features -->
    <section class="project-info mt-4">
        <h2 class="mt-5">Sobre la plataforma</h2>
        <p class="muted">
            Incidencias RD cuenta con todo lo necesario para registrar, visualizar y gestionar incidencias en todo el país.
        </p>

        <div class="features">
            <div class="feature-item">
                <div class="feature-media">
                    <img src="../imgs/home/incidence1.jpg" loading="lazy">
                </div>
                <div class="feature-body">
                    <h4>Incidencias Recientes</h4>
                    <p>Puedes ver con facilidad las incidencias de las ultimas 24h.</p>
                </div>
            </div>

            <div class="feature-item">
                <div class="feature-media">
                    <img src="../imgs/home/incidence_map.jpg" loading="lazy">
                </div>
                <div class="feature-body">
                    <h4>Visualización en Mapa</h4>
                    <p>Íconos por tipo de incidencia y clustering por provincia.</p>
                </div>
            </div>

            <div class="feature-item">
                <div class="feature-media">
                    <img src="../imgs/home/incidence_list.jpg" loading="lazy">
                </div>
                <div class="feature-body">
                    <h4>Vista en Lista</h4>
                    <p>Tabla paginada con botones interactivos y mucho más.</p>
                </div>
            </div>

            <div class="feature-item">
                <div class="feature-media">
                    <img src="../imgs/home/incidence2.jpg" loading="lazy">
                </div>
                <div class="feature-body">
                    <h4>Filtros y Búsqueda</h4>
                    <p>Filtra por provincia, tipo, rango de fechas o busca por el título de la incidencia.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="home-footer">
        <p class="mb-0">¿Dudas o problemas? <a href="#">Contáctenos</a></p>
    </footer>
</div>
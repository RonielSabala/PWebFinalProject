<?php

use App\Utils\GeneralUtils;
?>

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

    <div class="results-row d-flex justify-content-between align-items-center my-3">
        <!-- Contador de resultados -->
        <div id="resultsCount" class="mb-0">Cargando...</div>

        <!-- Botón para alternar limite inferior para las fechas -->
        <div class="d-flex align-items-center ms-3">
            <div class="form-check form-switch custom-switch align-items-center">
                <input class="form-check-input" type="checkbox" id="beautifulToggle" checked aria-checked="true" />
                <label class="form-check-label ms-2" for="beautifulToggle" id="beautifulToggleLabel">
                    Últimas 24h
                    <span id="beautifulToggleState" aria-hidden="true" class="badge-state">ON</span>
                </label>
            </div>
        </div>
    </div>

    <!-- Lista -->
    <table id="incidents-list" class="table">
        <thead>
            <tr>
                <th>Título</th>
                <th>Descripción</th>
                <th>Fecha de Publicación</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody id="incidents-tbody">
            <?php foreach ($incidents as $incidence): ?>
                <tr class="incident-row"
                    data-id="<?= $incidence['id'] ?>"
                    data-title="<?= strtolower($incidence['title']) ?>"
                    data-province="<?= $incidence['province_id'] ?>"
                    data-date="<?= $incidence['creation_date'] ?>"
                    data-lat="<?= $incidence['latitude'] ?>"
                    data-lng="<?= $incidence['longitude'] ?>">
                    <td class="incident-title"><?= $incidence['title'] ?></td>
                    <td class="incident-desc"><?= $incidence['incidence_description'] ?></td>
                    <td class="incident-date"><?= (new DateTime($incidence['creation_date']))->format('d/m/Y H:i') ?></td>
                    <td>
                        <div class="d-flex justify-content-end gap-2 align-items-center">
                            <!-- Botón abrir modal -->
                            <button type="button" class="btn btn-sm btn-outline-action btn-show-modal" data-id="<?= $incidence['id'] ?>" title="Ver detalles">
                                <i class="bi bi-info-circle"></i>
                            </button>

                            <!-- Abrir en otra pestaña -->
                            <a href="incidence.php?id=<?= $incidence['id'] ?>" class="btn btn-sm btn-outline-action btn-go" title="Abrir en otra pestaña">
                                <i class="bi bi-box-arrow-up-right"></i>
                            </a>

                            <!-- Copiar coordenadas -->
                            <button type="button"
                                class="btn btn-sm btn-outline-action btn-copy-coords"
                                data-lat="<?= $incidence['latitude'] ?>"
                                data-lng="<?= $incidence['longitude'] ?>"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                title="Copiar coordenadas">
                                <i class="bi bi-clipboard"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?= GeneralUtils::showNoData($incidents, "incidentes"); ?>

    <!-- Modal -->
    <div class="modal fade" id="incidenceModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-fullscreen-md-down">
            <div class="modal-content border-0 shadow-lg">
                <!-- Header -->
                <div class="modal-header p-3 align-items-start bg-incident">
                    <div class="d-flex align-items-center gap-3 w-100">
                        <div class="modal-hero-avatar" aria-hidden="true">
                            <!-- icono opcional -->
                            <i class="bi bi-exclamation-circle-fill"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="modal-title mb-0" id="incidenceModalLabel">Detalles de incidencia</h5>
                        </div>

                        <!-- Close -->
                        <button type="button" class="btn-close ms-3" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                </div>

                <!-- Body -->
                <div class="modal-body p-0">
                    <div id="modalBody" class="p-4 modal-body-content">
                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer d-flex align-items-center">
                    <a id="btnGoToIncidencePage" class="btn btn-primary me-auto" href="#" rel="noopener noreferrer">
                        Abrir en otra pestaña
                    </a>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const incidents = <?= json_encode($incidents) ?>;
</script>
<?php include_once('_partials/__header.php'); ?>

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
                <td class="incidence-title"><?= $incidence['title'] ?></td>
                <td class="incidence-desc"><?= $incidence['incidence_description'] ?></td>
                <td class="incidence-date"><?= (new DateTime($incidence['creation_date']))->format('d/m/Y H:i') ?></td>
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

<?php

App\Utils\GeneralUtils::showNoData($incidents, "incidentes");
include_once('_partials/__footer.php');

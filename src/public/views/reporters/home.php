<?php

use App\Utils\PrintUtils;
use App\Utils\GeneralUtils;
?>

<h2>Incidencias reportadas</h2>
<div class="d-flex justify-content-end mb-3">
    <a id="btn-create" href="report.php" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Crear
    </a>
</div>
<table class="table">
    <thead>
        <tr>
            <th>No.</th>
            <th>Título</th>
            <th>Descripción</th>
            <th>Fecha registrada</th>
            <th>Estatus</th>
            <th>Comentarios</th>
            <th>Correcciones</th>
            <th class="text-center">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($incidents as $incidence) {
        ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= $incidence['title'] ?></td>
                <td><?= PrintUtils::getPrintableText($incidence['incidence_description']) ?></td>
                <td><?= $incidence['creation_date'] ?></td>
                <td>
                    <span class="status-badge <?= ((int)$incidence['is_approved'] === 1) ? 'approved' : 'not-approved' ?>">
                        <?= ((int)$incidence['is_approved'] === 1) ? 'Aprobada' : 'No aprobada' ?>
                    </span>
                </td>
                <td><?= $incidence['comments_count'] ?></td>
                <td><?= $incidence['corrections_count'] ?></td>
                <td class="d-flex">
                    <a href="/incidents/incidence.php?id=<?= $incidence['id'] ?>" class="btn btn-sm btn-outline-action btn-go">
                        Ver
                        <i class="bi bi-box-arrow-up-right"></i>
                    </a>
                    <a href="/reporters/report.php?id=<?= $incidence['id'] ?>" class="btn btn-sm btn-outline-action btn-go">
                        Editar
                        <i class="bi bi-pencil-square"></i>
                    </a>
                </td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>

<?= GeneralUtils::showNoData($incidents, "incidencias"); ?>
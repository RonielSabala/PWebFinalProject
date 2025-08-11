<?php

use App\Utils\GeneralUtils;
?>

<h2>Incidencias reportadas</h2>
<div class="d-flex justify-content-end mb-3">
    <a id="btn-create" href="edit_incidence.php" class="btn btn-primary">
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
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($incidents as $incidence) {
        ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= htmlspecialchars($incidence['title']) ?></td>
                <td><?= htmlspecialchars($incidence['incidence_description']) ?></td>
                <td><?= htmlspecialchars($incidence['creation_date']) ?></td>
                <td>
                    <span class="status-badge <?= ((int)$incidence['is_approved'] === 1) ? 'approved' : 'not-approved' ?>">
                        <?= ((int)$incidence['is_approved'] === 1) ? 'Aprobada' : 'No aprobada' ?>
                    </span>
                </td>
                <td><?= htmlspecialchars($incidence['comments']) ?></td>
                <td>
                    <a href="/incidents/incidence.php?id=<?= $incidence['id'] ?>" class="btn btn-sm btn-outline-action btn-go">
                        Ver
                        <i class="bi bi-box-arrow-up-right"></i>
                    </a>
                </td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>

<?= GeneralUtils::showNoData($incidents, "incidencias"); ?>
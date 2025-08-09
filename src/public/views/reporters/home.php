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
            <th>Comentarios</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($incidents as $incident) {
        ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= htmlspecialchars($incident['title']) ?></td>
                <td><?= htmlspecialchars($incident['incidence_description']) ?></td>
                <td><?= htmlspecialchars($incident['creation_date']) ?></td>
                <td><?= htmlspecialchars($incident['comments']) ?></td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>

<?= GeneralUtils::showNoData($incidents, "incidencias"); ?>
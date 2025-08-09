<?php

use App\Utils\GeneralUtils;
?>

<h2>Listado de barrios</h2>
<div class="d-flex justify-content-end mb-3">
    <a id="btn-create" href="create.php" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Crear
    </a>
</div>
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Municipio</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($neighborhoods as $neighborhood): ?>
            <tr>
                <td><?= htmlspecialchars($neighborhood['id']) ?></td>
                <td><?= htmlspecialchars($neighborhood['neighborhood_name']) ?></td>
                <td><?= htmlspecialchars($neighborhood['municipality_name']) ?></td>
                <td>
                    <div class="d-flex gap-1">
                        <a href="edit.php?id=<?= $neighborhood['id'] ?>" class="btn btn-outline-action btn-warning" title="Editar">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <a href="delete.php?id=<?= $neighborhood['id'] ?>" class="btn btn-outline-action btn-danger" title="Eliminar">
                            <i class="bi bi-trash"></i>
                        </a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= GeneralUtils::showNoData($neighborhoods, "barrios"); ?>
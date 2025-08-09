<?php

use App\Utils\GeneralUtils;
?>

<h2>Listado de provincias</h2>
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
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($provinces as $province): ?>
            <tr>
                <td><?= htmlspecialchars($province['id']) ?></td>
                <td><?= htmlspecialchars($province['province_name']) ?></td>
                <td>
                    <div class="d-flex gap-1">
                        <a href="edit.php?id=<?= $province['id'] ?>" class="btn btn-outline-action btn-warning" title="Editar">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <a href="delete.php?id=<?= $province['id'] ?>" class="btn btn-outline-action btn-danger" title="Eliminar">
                            <i class="bi bi-trash"></i>
                        </a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= GeneralUtils::showNoData($provinces, "provincias"); ?>
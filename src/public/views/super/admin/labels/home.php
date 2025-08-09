<?php

use App\Utils\GeneralUtils;
?>

<h2>Listado de etiquetas</h2>
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
            <th>Ícono</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($labels as $label): ?>
            <tr>
                <td><?= htmlspecialchars($label['id']) ?></td>
                <td><?= htmlspecialchars($label['label_name']) ?></td>
                <td>
                    <img src="<?= htmlspecialchars($label['icon_url']) ?>" alt="etiqueta" style="width: 70px;">
                </td>
                <td>
                    <div class="d-flex gap-1">
                        <a href="edit.php?id=<?= $label['id'] ?>" class="btn btn-outline-action btn-warning" title="Editar">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <a href="delete.php?id=<?= $label['id'] ?>" class="btn btn-outline-action btn-danger" title="Eliminar">
                            <i class="bi bi-trash"></i>
                        </a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= GeneralUtils::showNoData($labels, "etiquetas"); ?>
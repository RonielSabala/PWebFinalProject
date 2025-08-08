<h2>Etiquetas</h2>

<a href="create.php" class="btn btn-primary">Crear nueva etiqueta</a>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($labels as $label): ?>
            <tr>
                <td><?= htmlspecialchars($label['id']) ?></td>
                <td><?= htmlspecialchars($label['label_name']) ?></td>
                <td>
                    <a href="edit.php?id=<?= $label['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                    <a href="delete.php?id=<?= $label['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta etiqueta?')">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
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
        <?php foreach ($labels as $tag): ?>
            <tr>
                <td><?= htmlspecialchars($tag['id']) ?></td>
                <td><?= htmlspecialchars($tag['name']) ?></td>
                <td>
                    <a href="edit.php?id=<?= $tag['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                    <a href="delete.php?id=<?= $tag['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta etiqueta?')">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
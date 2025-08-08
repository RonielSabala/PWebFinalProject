<h2>Municipios</h2>

<a href="create.php" class="btn btn-primary">Crear nuevo municipio</a>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Provincia</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($municipalities as $municipality): ?>
            <tr>
                <td><?= htmlspecialchars($municipality['id']) ?></td>
                <td><?= htmlspecialchars($municipality['municipality_name']) ?></td>
                <td>
                    <?php
                    foreach ($provinces as $province) {
                        if ($province['id'] == $municipality['province_id']) {
                            echo htmlspecialchars($province['province_name']);
                            break;
                        }
                    }
                    ?>
                </td>
                <td>
                    <a href="edit.php?id=<?= $municipality['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                    <a href="delete.php?id=<?= $municipality['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este municipio?')">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
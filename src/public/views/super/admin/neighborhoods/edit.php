<h2>Editar Barrio</h2>

<form method="POST">
    <input type="hidden" name="id" value="<?= $neighborhood['id'] ?>">

    <div class="form-group">
        <label for="name">Nombre del Barrio</label>
        <input type="text" name="name" id="name" class="form-control" value="<?= htmlspecialchars($neighborhood['name']) ?>" required>
    </div>

    <div class="form-group">
        <label for="municipality_id">Municipio</label>
        <select name="municipality_id" id="municipality_id" class="form-control" required>
            <?php foreach ($municipalities as $municipality): ?>
                <option value="<?= $municipality['id'] ?>" <?= $municipality['id'] == $neighborhood['municipality_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($municipality['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Actualizar</button>
    <a href="index.php" class="btn btn-secondary">Cancelar</a>
</form>
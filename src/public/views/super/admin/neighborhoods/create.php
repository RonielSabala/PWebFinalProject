<h2>Crear Barrio</h2>

<form method="POST">
    <div class="form-group">
        <label for="name">Nombre del Barrio</label>
        <input type="text" name="name" id="name" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="municipality_id">Municipio</label>
        <select name="municipality_id" id="municipality_id" class="form-control" required>
            <option value="">Seleccione un municipio</option>
            <?php foreach ($municipalities as $municipality): ?>
                <option value="<?= $municipality['id'] ?>"><?= htmlspecialchars($municipality['name']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <button type="submit" class="btn btn-success">Guardar</button>
    <a href="home.php" class="btn btn-secondary">Cancelar</a>
</form>
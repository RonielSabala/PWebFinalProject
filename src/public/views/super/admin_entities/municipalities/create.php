<h2>Crear Municipio</h2>

<form method="POST">
    <div class="form-group">
        <label for="name">Nombre del Municipio</label>
        <input type="text" name="name" id="name" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="province_id">Provincia</label>
        <select name="province_id" id="province_id" class="form-control" required>
            <option value="">Seleccione una provincia</option>
            <?php foreach ($provinces as $province): ?>
                <option value="<?= $province['id'] ?>"><?= htmlspecialchars($province['name']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <button type="submit" class="btn btn-success">Guardar</button>
    <a href="index.php" class="btn btn-secondary">Cancelar</a>
</form>
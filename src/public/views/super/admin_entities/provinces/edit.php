<h1>Editar Provincia</h1>

<form method="POST">
    <input type="hidden" name="id" value="<?= htmlspecialchars($province['id']) ?>">

    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre de la Provincia:</label>
        <input type="text" name="nombre" id="nombre" class="form-control" value="<?= htmlspecialchars($province['nombre']) ?>" required>
    </div>

    <button type="submit" class="btn btn-primary">Actualizar</button>
    <a href="index.php" class="btn btn-secondary">Cancelar</a>
</form>
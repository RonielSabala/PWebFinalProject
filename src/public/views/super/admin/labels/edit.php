<h2>Editar Etiqueta</h2>

<form method="POST">
    <input type="hidden" name="id" value="<?= $tag['id'] ?>">

    <div class="form-group">
        <label for="name">Nombre de la Etiqueta</label>
        <input type="text" name="name" id="name" class="form-control" value="<?= htmlspecialchars($tag['name']) ?>" required>
    </div>

    <button type="submit" class="btn btn-primary">Actualizar</button>
    <a href="index.php" class="btn btn-secondary">Cancelar</a>
</form>
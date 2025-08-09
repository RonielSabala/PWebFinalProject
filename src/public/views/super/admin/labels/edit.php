<div class="container center-screen pt-2 mb-3">
    <div class="card shadow-sm entity-card w-100" style="max-width: 1000px;">
        <div class="card-header bg-warning text-dark">
            <h3 class="mb-0">Editar etiqueta</h3>
        </div>
        <div class="card-body">
            <h5 class="text-secondary mb-3">Actualiza los campos necesarios</h5>
            <hr>
            <form method="post">
                <div class="edit-grid">
                    <div class="edit-item">
                        <label for="label_name" class="form-label">Nombre de la etiqueta</label>
                        <input type="text" id="label_name" name="label_name" class="form-control" placeholder="Escribe el nombre de la etiqueta" value="<?= $label['label_name']; ?>" required>
                    </div>
                    <div class="edit-item">
                        <label for="icon_url" class="form-label">Url del icono</label>
                        <input type="text" id="icon_url" name="icon_url" class="form-control" placeholder="Escribe la url del ícono de la etiqueta" value="<?= $label['icon_url']; ?>" required>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-4 action-buttons">
                    <button type="submit" id="btn-edit" class="btn btn-warning btn-lg text-black">
                        <i class="bi bi-pencil-square me-2"></i> Actualizar
                    </button>
                    <a id="btn-return" class="btn btn-outline-secondary btn-lg" href="home.php">
                        <i class="bi bi-arrow-left-circle me-2"></i> Volver
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
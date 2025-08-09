<div class="container center-screen pt-2">
    <div class="card shadow-sm entity-card w-100">
        <div class="card-header bg-danger text-white">
            <h3 class="mb-0">Eliminar etiqueta</h3>
        </div>
        <div class="card-body">
            <div class="delete-warning">
                <h5>
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    Estas seguro de que quieres eliminar esta <strong>etiqueta</strong>?
                </h5>
            </div>

            <form method="post">
                <dl class="row">
                    <div class="fields-grid">
                        <div class="field-item">
                            <label for="label_name" class="field-label">Nombre de la etiqueta</label>
                            <div id="label_name" name="label_name" class="field-value"><?= $label['label_name']; ?></div>
                        </div>
                        <div class="field-item">
                            <label class="field-label">Ícono</label>
                            <img src="<?= htmlspecialchars($label['icon_url']) ?>" alt="etiqueta" style="width: 150px;">
                        </div>
                    </div>
                </dl>

                <div class="d-flex justify-content-between align-items-center mt-4 action-buttons">
                    <button type="submit" id="btn-delete" class="btn btn-lg btn-danger">
                        <i class="bi bi-trash3-fill me-2"></i> Eliminar
                    </button>
                    <a id="btn-return" class="btn btn-outline-secondary btn-lg" href="home.php">
                        <i class="bi bi-arrow-left-circle me-2"></i> Volver
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="container center-screen pt-2">
    <div class="card shadow-sm entity-card w-100">
        <div class="card-header bg-danger text-white">
            <h3 class="mb-0">Eliminar barrio</h3>
        </div>
        <div class="card-body">
            <div class="delete-warning">
                <h5>
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    Estas seguro de que quieres eliminar este <strong>barrio</strong>?
                </h5>
            </div>

            <form method="post">
                <dl class="row">
                    <div class="fields-grid">
                        <div class="field-item">
                            <label for="neighborhood_name" class="field-label">Nombre del barrio</label>
                            <div id="neighborhood_name" name="neighborhood_name" class="field-value"><?= $neighborhood['neighborhood_name']; ?></div>
                        </div>
                        <div class="field-item">
                            <label for="municipality_id" class="field-label">Municipio</label>
                            <div id="municipality_id" name="municipality_id" class="field-value"><?= $municipality['municipality_name']; ?></div>
                        </div>
                        <div class="field-item">
                            <label for="province_id" class="field-label">Provincia</label>
                            <div id="province_id" name="province_id" class="field-value"><?= $province['province_name']; ?></div>
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
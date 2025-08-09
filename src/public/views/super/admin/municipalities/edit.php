<div class="container center-screen pt-2 mb-3">
    <div class="card shadow-sm entity-card w-100" style="max-width: 1000px;">
        <div class="card-header bg-warning text-dark">
            <h3 class="mb-0">Editar municipio</h3>
        </div>
        <div class="card-body">
            <h5 class="text-secondary mb-3">Actualiza los campos necesarios</h5>
            <hr>
            <form method="post">
                <div class="edit-grid">
                    <div class="edit-item">
                        <label for="province_id" class="form-label">Nombre de la provincia</label>
                        <select id="province_id" class="form-select" name="province_id" required>
                            <?php foreach ($provinces as $prov): ?>
                                <option
                                    value="<?= $prov['id'] ?>"
                                    <?= ($prov['id'] == $default_province) ? 'selected' : '' ?>>
                                    <?= $prov['province_name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="edit-item">
                        <label for="municipality_name" class="form-label">Nombre del municipio</label>
                        <input type="text" id="municipality_name" name="municipality_name" class="form-control" placeholder="Escribe el nombre del municipio" value="<?= $municipality['municipality_name']; ?>" required>
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
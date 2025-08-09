<div class="container center-screen pt-2 mb-3">
    <div class="card shadow-sm entity-card w-100" style="max-width: 1000px;">
        <div class="card-header bg-success text-white">
            <h3 class="mb-0">Crear nueva provincia</h3>
        </div>
        <div class="card-body">
            <h5 class="text-secondary mb-3">Completa los datos</h5>
            <hr>
            <form method="post">
                <div class="edit-grid">
                    <div class="edit-item">
                        <label for="province_name" class="form-label">Nombre de la provincia</label>
                        <input type="text" id="province_name" name="province_name" class="form-control" placeholder="Escribe el nombre de la provincia" required>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-4 action-buttons">
                    <button type="submit" id="btn-create" class="btn btn-success btn-lg">
                        <i class="bi bi-plus-circle me-2"></i> Crear
                    </button>
                    <a id="btn-return" class="btn btn-outline-secondary btn-lg" href="home.php">
                        <i class="bi bi-arrow-left-circle me-2"></i> Volver
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php

use App\Utils\PrintUtils;
?>

<div class="container center-screen pt-2">
    <div class="card shadow-sm entity-card w-100">
        <div class="card-header bg-danger text-white">
            <h3 class="mb-0">Rechazar incidencia</h3>
        </div>
        <div class="card-body">
            <div class="delete-warning">
                <h5>
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    Estas seguro de que quieres rechazar esta <strong>incidencia</strong>?
                </h5>
            </div>

            <form method="post">
                <dl class="row">
                    <div class="fields-grid">
                        <div class="field-item">
                            <label for="title" class="field-label">Título</label>
                            <div id="title" name="title" class="field-value"><?= $incidence['title'] ?></div>
                        </div>
                        <div class="field-item">
                            <label for="description" class="field-label">Descripción</label>
                            <div id="description" name="description" class="field-value"><?= PrintUtils::getPrintableText($incidence['incidence_description']) ?></div>
                        </div>
                        <div class="field-item">
                            <label for="creation_date" class="field-label">Fecha de registro</label>
                            <div id="creation_date" name="creation_date" class="field-value"><?= $incidence['creation_date'] ?></div>
                        </div>
                    </div>
                </dl>

                <div class="d-flex justify-content-between align-items-center mt-4 action-buttons">
                    <button type="submit" id="btn-delete" class="btn btn-lg btn-danger">
                        <i class="bi bi-trash3-fill me-2"></i> Rechazar
                    </button>
                    <a id="btn-return" class="btn btn-outline-secondary btn-lg" href="incidence_validation.php">
                        <i class="bi bi-arrow-left-circle me-2"></i> Volver
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
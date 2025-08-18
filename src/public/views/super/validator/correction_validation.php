<?php

use App\Utils\PrintUtils;
use App\Utils\GeneralUtils;
?>

<div class="row mb-4">
    <div class="col-md-8">
        <div class="hero d-flex gap-3 align-items-center">
            <div class="icon-box rounded-3">
                <i class="bi bi-clipboard-check fs-3" style="color: var(--accent-2)"></i>
            </div>
            <div>
                <h2 class="mb-0">Corregir incidencias</h2>
                <p class="muted-sm mt-2 mb-0">
                    Revisa las solicitudes de corrección de incidencias y decide si aprobarlas o rechazarlas.
                </p>
            </div>
        </div>
    </div>
</div>

<?php if (!empty($corrections)): ?>
    <?php $i = 1;
    foreach ($corrections as $correction): ?>
        <div class="correction-card mb-4 p-4 rounded-3 shadow-sm">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <h4 class="mb-0">Solicitud de corrección #<?= $i++ ?></h4>
                <span class="text-muted"><?= PrintUtils::getPrintableDate($correction['creation_date']) ?></span>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <h5 class="text-muted small mb-2">Corrector</h5>
                    <p class="fs-5"><?= $correction['username'] ?></p>
                </div>

                <div class="col-md-6 text-end">
                    <h5 class="text-muted small mb-2">Incidencia relacionada</h5>
                    <a href="/incidents/incidence.php?id=<?= $correction['incidence_id'] ?>"
                        class="btn btn-primary-action">
                        Ver <i class="bi bi-box-arrow-up-right"></i>
                    </a>
                </div>
            </div>

            <div class="mb-4">
                <h5 class="text-muted small mb-2">Cambios propuestos</h5>
                <div class="correction-values p-3 bg-light rounded-2">
                    <?= PrintUtils::getPrintableJson($correction['correction_values']) ?>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-3">
                <a href="reject_correction.php?id=<?= $correction['id'] ?>" class="btn btn-lg btn-outline-danger">
                    <i class="bi bi-x-lg me-2"></i> Rechazar
                </a>
                <a href="approve_correction.php?id=<?= $correction['id'] ?>" class="btn btn-lg btn-success">
                    <i class="bi bi-check-lg me-2"></i> Aprobar
                </a>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <?= GeneralUtils::showNoData($corrections, "solicitudes de corrección"); ?>
<?php endif; ?>
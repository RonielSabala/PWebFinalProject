<?php

use App\Utils\GeneralUtils;
?>

<div class="row mb-4">
    <div class="col-md-8">
        <h2 class="mb-0"><i class="bi bi-clipboard-check text-primary"></i> Validación de incidencias</h2>
        <p class="small-muted mb-0">Revisa las incidencias pendientes y decide si aprobarlas o rechazarlas.</p>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <?php if (empty($incidents)): ?>
            <?= GeneralUtils::showNoData($incidents, "incidencias pendientes"); ?>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Descripción</th>
                            <th>Fecha ocurrencia</th>
                            <th>Ubicación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($incidents as $inc): ?>
                            <tr>
                                <td><?= htmlspecialchars($inc['title']) ?></td>
                                <td><?= htmlspecialchars($inc['incidence_description']) ?></td>
                                <td><?= htmlspecialchars($inc['occurrence_date']) ?></td>
                                <td>
                                    <?= htmlspecialchars($inc['province'] ?? '-') ?>,
                                    <?= htmlspecialchars($inc['municipality'] ?? '-') ?>,
                                    <?= htmlspecialchars($inc['neighborhood'] ?? '-') ?>
                                </td>
                                <td>
                                    <a href="/super/validator/approve?id=<?= $inc['id'] ?>" class="btn btn-success btn-sm">
                                        <i class="bi bi-check-circle"></i> Aprobar
                                    </a>
                                    <a href="/super/validator/reject?id=<?= $inc['id'] ?>" class="btn btn-danger btn-sm">
                                        <i class="bi bi-x-circle"></i> Rechazar
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

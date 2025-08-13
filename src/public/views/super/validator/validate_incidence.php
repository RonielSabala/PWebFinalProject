<?php

use App\Utils\GeneralUtils;
?>

<div class="row mb-4">
    <div class="col-md-8">
        <h2 class="mb-0"><i class="bi bi-clipboard-check text-primary"></i> Validación de incidencias</h2>
        <p class="small-muted mt-2 mb-0">Revisa las incidencias pendientes y decide si aprobarlas o rechazarlas.</p>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <h4>Incidencias pendientes</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Título</th>
                        <th>Descripción</th>
                        <th>Fecha registrada</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;
                    foreach ($incidents as $incidence): ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= htmlspecialchars($incidence['title']) ?></td>
                            <td><?= htmlspecialchars($incidence['incidence_description']) ?></td>
                            <td><?= htmlspecialchars($incidence['creation_date']) ?></td>
                            <td>
                                <a href="/super/validator/approve.php?id=<?= $incidence['id'] ?>" class="btn btn-success btn-sm">Aprobar</a>
                                <a href="/super/validator/reject.php?id=<?= $incidence['id'] ?>" class="btn btn-danger btn-sm">Rechazar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?= GeneralUtils::showNoData($incidents, "incidencias pendientes"); ?>
        </div>
    </div>
</div>
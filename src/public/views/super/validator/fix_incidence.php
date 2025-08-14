<?php

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

<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>No.</th>
                <th>Incidencia</th>
                <th>Hecha por</th>
                <th>Correcciones</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1;
            foreach ($corrections as $correction): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td>
                        <div class="d-flex justify-content-center">
                            <a href="/incidents/incidence.php?id=<?= $correction['id'] ?>" class="btn btn-sm btn-outline-action btn-go" title="Abrir en pantalla completa">
                                <i class="bi bi-box-arrow-up-right"></i>
                            </a>
                        </div>
                    </td>
                    <td><?= htmlspecialchars($correction['username']) ?></td>
                    <td><?= htmlspecialchars($correction['correction_values']) ?></td>
                    <td>
                        <a href="approve.php?id=<?= $correction['id'] ?>" class="btn btn-success btn-sm">Aprobar</a>
                        <a href="reject.php?id=<?= $correction['id'] ?>" class="btn btn-danger btn-sm">Rechazar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?= GeneralUtils::showNoData($corrections, "solicitudes de corrección"); ?>
</div>
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
                <h2 class="mb-0">Incidencias pendientes</h2>
                <p class="muted-sm mt-2 mb-0">
                    Revisa las incidencias pendientes y decide si aprobarlas o rechazarlas.
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
                    <td><?= $incidence['title'] ?></td>
                    <td><?= PrintUtils::getPrintableText($incidence['incidence_description']) ?></td>
                    <td><?= $incidence['creation_date'] ?></td>
                    <td>
                        <a
                            href="approve_incidence.php?id=<?= $incidence['id'] ?>"
                            class="btn-modern btn-approve btn-sm"
                            title="Aprobar">
                            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" focusable="false">
                                <path d="M20 6L9 17l-5-5" stroke="white" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <span>Aprobar</span>
                        </a>
                        <a
                            href="reject_incidence.php?id=<?= $incidence['id'] ?>"
                            class="btn-modern btn-reject btn-sm"
                            title="Rechazar">
                            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" focusable="false">
                                <path d="M18 6L6 18M6 6l12 12" stroke="white" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <span>Rechazar</span>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?= GeneralUtils::showNoData($incidents, "incidencias pendientes"); ?>
</div>
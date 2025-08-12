<?php

use App\Utils\GeneralUtils;
?>

<!-- Header -->
<div class="row align-items-center mb-4">
    <div class="hero d-flex gap-3 align-items-center">
        <div class="rounded-3 p-3 bg-white" style="width:64px;height:64px;display:flex;align-items:center;justify-content:center;">
            <i class="bi bi-check-circle-fill fs-3" style="color:var(--accent-1)"></i>
        </div>
        <div>
            <h3 class="mb-0">Vista del validador</h3>
            <div class="muted-sm">
                Bienvenido, <span class="welcome-name"><?= htmlspecialchars($_SESSION['user']['username'] ?? 'Validador') ?></span>! —
                Panel para gestionar las incidencias pendientes.
            </div>
        </div>
        <div class="ms-auto text-end">
            <span class="badge badge-accent px-3 py-2">Rol: Validador</span>
        </div>
    </div>
</div>

<hr class="my-4">

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
        <?php if (!empty($incidents)): ?>
            <?php $i = 1; foreach ($incidents as $incidence): ?>
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
        <?php else: ?>
            <tr>
                
                <td colspan="5" class="text-center">No hay incidencias pendientes</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>


<!-- Shortcuts -->
<div class="card p-3">
    <div class="d-flex align-items-center mb-3">
        <h5 class="mb-0">Acciones rápidas</h5>
        <small class="muted-sm ms-3">Tareas más frecuentes</small>
    </div>

    <div class="row g-3">
        <div class="col-6">
            <a href="/super/validator/validateIncidence.php" class="d-block p-3 bg-white rounded shortcut text-decoration-none">
                <div class="d-flex align-items-center">
                    <i class="bi bi-list-check me-3 fs-3" style="color:var(--accent-1)"></i>
                    <div>
                        <div class="fw-semibold">Validar incidencias</div>
                        <div class="muted-sm">Aprobar o rechazar reportes</div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

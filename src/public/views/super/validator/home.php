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

<!-- Quick stats -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-4">
        <div class="card stat-card">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1">
                    <div class="muted-sm">Incidencias pendientes</div>
                    <h4 class="mb-0"><?= number_format($pending_incidents_count) ?></h4>
                </div>
                <div class="ms-3">
                    <i class="bi bi-exclamation-circle-fill fs-2" style="color:var(--accent-1)"></i>
                </div>
            </div>
            <div class="mt-2 muted-sm">Esperando aprobación o rechazo.</div>
        </div>
    </div>
</div>

<!-- Shortcuts -->
<div class="card p-3">
    <div class="d-flex align-items-center mb-3">
        <h5 class="mb-0">Acciones rápidas</h5>
        <small class="muted-sm ms-3">Tareas más frecuentes</small>
    </div>

    <div class="row g-3">
        <div class="col-6">
            <a href="/super/validator/incidences/validateIncidence.php" class="d-block p-3 bg-white rounded shortcut text-decoration-none">
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

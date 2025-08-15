<!-- Header -->
<div class="row align-items-center mb-4">
    <div class="hero d-flex gap-3 align-items-center">
        <div class="rounded-3 p-3 bg-white" style="width:64px;height:64px;display:flex;align-items:center;justify-content:center;">
            <i class="bi bi-shield-lock-fill fs-3" style="color:var(--accent-1)"></i>
        </div>
        <div>
            <h3 class="mb-0">Panel del administrador</h3>
            <div class="muted-sm">Bienvenido, <span class="welcome-name"><?= htmlspecialchars($_SESSION['user']['username'] ?? 'Administrador') ?></span>! — Panel para gestionar la aplicación rápidamente.</div>
        </div>
        <div class="ms-auto text-end">
            <span class="badge badge-accent px-3 py-2">Rol: Administrador</span>
        </div>
    </div>
</div>

<!-- Quick stats -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-4">
        <div class="card stat-card">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1">
                    <div class="muted-sm">Usuarios</div>
                    <h4 class="mb-0"><?= number_format($users_count) ?></h4>
                </div>
                <div class="ms-3">
                    <i class="bi bi-people-fill fs-2" style="color:var(--accent-1)"></i>
                </div>
            </div>
            <div class="mt-2 muted-sm">Gestiona roles y permisos de los usuarios.</div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-4">
        <div class="card stat-card">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1">
                    <div class="muted-sm">Roles</div>
                    <h4 class="mb-0"><?= number_format($roles_count) ?></h4>
                </div>
                <div class="ms-3">
                    <i class="bi bi-shield-lock fs-2" style="color:#f97316"></i>
                </div>
            </div>
            <div class="mt-2 muted-sm">Configura roles y niveles de acceso.</div>
        </div>
    </div>
</div>

<!-- Shortcuts & CRUD -->

<div class="card p-3">
    <div class="d-flex align-items-center mb-3">
        <h5 class="mb-0">Acciones rápidas</h5>
        <small class="muted-sm ms-3">Atajos para las tareas más frecuentes</small>
    </div>

    <div class="row g-3">
        <div class="col-6">
            <a href="/super/admin/users.php" class="d-block p-3 bg-white rounded shortcut text-decoration-none">
                <div class="d-flex align-items-center">
                    <i class="bi bi-people me-3 fs-3" style="color:var(--accent-1)"></i>
                    <div>
                        <div class="fw-semibold">Gestionar usuarios</div>
                        <div class="muted-sm">Permisos y roles</div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-6">
            <a href="/super/admin/provinces/home.php" class="d-block p-3 bg-white rounded shortcut text-decoration-none">
                <div class="d-flex align-items-center">
                    <i class="bi bi-geo-alt-fill me-3 fs-3" style="color:#3b82f6"></i>
                    <div>
                        <div class="fw-semibold">Provincias</div>
                        <div class="muted-sm">CRUD de provincias (<?= $provinces_count ?>)</div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-6">
            <a href="/super/admin/municipalities/home.php" class="d-block p-3 bg-white rounded shortcut text-decoration-none">
                <div class="d-flex align-items-center">
                    <i class="bi bi-building me-3 fs-3" style="color:#06b6d4"></i>
                    <div>
                        <div class="fw-semibold">Municipios</div>
                        <div class="muted-sm">CRUD de municipios (<?= $municipalities_count ?>)</div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-6">
            <a href="/super/admin/neighborhoods/home.php" class="d-block p-3 bg-white rounded shortcut text-decoration-none">
                <div class="d-flex align-items-center">
                    <i class="bi bi-house-fill me-3 fs-3" style="color:#10b981"></i>
                    <div>
                        <div class="fw-semibold">Barrios</div>
                        <div class="muted-sm">CRUD de barrios (<?= $neighborhoods_count ?>)</div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-6">
            <a href="/super/admin/labels/home.php" class="d-block p-3 bg-white rounded shortcut text-decoration-none">
                <div class="d-flex align-items-center">
                    <i class="bi bi-tag-fill me-3 fs-3" style="color:#8b5cf6"></i>
                    <div>
                        <div class="fw-semibold">Etiquetas</div>
                        <div class="muted-sm">CRUD de etiquetas (<?= $labels_count ?>)</div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
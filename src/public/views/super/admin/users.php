<?php

use App\Utils\GeneralUtils;
?>

<div class="row mb-4">
    <div class="col-md-8">
        <h2 class="mb-0"><i class="bi bi-people-fill text-primary"></i> Gestión de usuarios y roles</h2>
        <p class="small-muted mb-0">Actualiza rápidamente el rol de un usuario y visualiza los cambios antes de guardar.</p>
    </div>
</div>

<div class="row g-4">
    <!-- FORM -->
    <div class="col-lg-7">
        <div class="card card-hero shadow-sm">
            <div class="card-body">
                <form method="POST" class="row g-3" id="userRoleForm">
                    <!-- Select usuario -->
                    <div class="col-12">
                        <label for="user_id" class="form-label required">Selecciona un usuario</label>
                        <select id="user_id" name="user_id" class="form-select" required>
                            <?php foreach ($users as $user): ?>
                                <option
                                    value="<?= htmlspecialchars($user['id']) ?>"
                                    data-email="<?= htmlspecialchars($user['email']) ?>"
                                    data-roles="<?= htmlspecialchars($user['roles']) ?>"
                                    <?= ($user['id'] == $default_user) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($user['username']) ?> — <?= htmlspecialchars($user['email']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <!-- Mensaje si no hay usuarios -->
                        <div class="mt-2">
                            <?= GeneralUtils::showNoData($users, "usuarios"); ?>
                        </div>
                    </div>

                    <!-- Select rol -->
                    <div class="col-md-8">
                        <label for="role_id" class="form-label required">Asignar nuevo rol</label>
                        <select id="role_id" name="role_id" class="form-select" required>
                            <?php foreach ($roles as $role): ?>
                                <option value="<?= htmlspecialchars($role['id']) ?>" <?= ($role['id'] == $default_role) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($role['role_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Botones -->
                    <div class="col-md-4 d-flex align-items-end justify-content-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-save2 me-1"></i> Guardar
                        </button>
                    </div>

                    <!-- Mensaje si no hay roles -->
                    <div class="col-12">
                        <?= GeneralUtils::showNoData($roles, "roles"); ?>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Preview -->
    <div class="col-lg-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div id="previewAvatar" class="avatar">JD</div>
                    <div>
                        <h5 id="previewName" class="mb-0">Nombre de usuario</h5>
                        <div class="small-muted" id="previewEmail">email@ejemplo.com</div>
                    </div>
                    <div class="ms-auto text-end">
                        <span id="previewRoleBadge" class="badge bg-secondary badge-role">Rol actual</span>
                    </div>
                </div>

                <hr>

                <h6 class="mb-2">Detalles rápidos</h6>
                <ul class="list-unstyled small">
                    <li><i class="bi bi-person-lines-fill me-2"></i> ID seleccionado: <strong id="previewId">—</strong></li>
                    <li class="mt-1"><i class="bi bi-key-fill me-2"></i> Roles existentes: <span id="previewRolesText">—</span></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="mt-3">
        <small class="text-muted">Al guardar, el rol seleccionado se aplicará al usuario. Asegúrate de revisar antes de confirmar.</small>
    </div>
</div>
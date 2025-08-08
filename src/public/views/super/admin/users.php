<?php

use App\Utils\GeneralUtils;
?>

<h2>Gestión de usuarios y roles</h2>
<form method="POST">
    <label for="user_id">Selecciona un usuario:</label>
    <select name="user_id" required>
        <?php foreach ($users as $user): ?>
            <option value="<?= $user['id'] ?>" <?= $user['id'] == $default_user ? 'selected' : '' ?>>
                <?= $user['username'] ?> (<?= $user['email'] ?>) - Rol: <?= $user['roles'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <?= GeneralUtils::showNoData($users, "usuarios"); ?>

    <label for="role_id">Asignar nuevo rol:</label>
    <select name="role_id" required>
        <?php foreach ($roles as $role): ?>
            <option value="<?= $role['id'] ?>" <?= $role['id'] == $default_role ? 'selected' : '' ?>>
                <?= $role['role_name'] ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Guardar</button>

    <?= GeneralUtils::showNoData($roles, "roles"); ?>
</form>
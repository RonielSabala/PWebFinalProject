<h2>Gestión de Usuarios y Roles</h2>

<form method="POST">
    <label for="user_id">Selecciona un usuario:</label>
    <select name="user_id" required>
        <?php foreach ($users as $user): ?>
            <option value="<?= $user['id'] ?>">
                <?= $user['username'] ?> (<?= $user['email'] ?>) - Roles actuales: <?= $user['roles'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="role_id">Asignar nuevo rol:</label>
    <select name="role_id" required>
        <option value="1">default</option>
        <option value="2">reportero</option>
        <option value="3">validador</option>
        <option value="4">admin</option>
    </select>

    <button type="submit">Guardar</button>
</form>
<?php

namespace App\Controllers\Super\Admin;

use App\Core\Template;
use App\Utils\Entities\UserUtils;
use App\Utils\Entities\RoleUtils;


class UserController
{
    public function handle(Template $template)
    {
        $userId = null;
        $roleId = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_POST['user_id'];
            $roleId = $_POST['role_id'];
            RoleUtils::clearUserRoles($userId);
            RoleUtils::assignUserRole($userId, $roleId);
        }

        $session_user_id = $_SESSION['user']['id'];
        $allUsers = UserUtils::getAll();
        $filteredUsers = array_values(array_filter($allUsers, function ($u) use ($session_user_id) {
            return $u['id'] != $session_user_id;
        }));

        $template->apply([
            'users' => $filteredUsers,
            'roles' => RoleUtils::getAll(),
            'default_user' => $userId,
            'default_role' => $roleId,
        ]);
    }
}

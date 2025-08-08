<?php

namespace App\Controllers\Super;

use App\Core\Template;
use \App\Utils\Entities\UserUtils;


class AdminController
{
    public function handle(Template $template)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_POST['user_id'];
            $roleId = $_POST['role_id'];
            UserUtils::clearRoles($userId);
            UserUtils::assignRole($userId, $roleId);
        }

        $users = UserUtils::getAllUsersWithRoles();
        $template->apply(['users' => $users]);
    }
}

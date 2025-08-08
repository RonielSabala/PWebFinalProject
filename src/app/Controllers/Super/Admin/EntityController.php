<?php

namespace App\Controllers\Super\Admin;

use App\Core\Template;
use App\Utils\Entities\UserUtils;
use App\Utils\Entities\RoleUtils;
use App\Utils\Entities\LabelUtils;
use App\Utils\Entities\ProvinceUtils;
use App\Utils\Entities\MunicipalityUtils;
use App\Utils\Entities\NeighborhoodUtils;


class EntityController
{
    public function handle(Template $template)
    {
        $data = [];
        $route = $template::$viewPath;

        if (str_contains($route, 'users')) {
            $data = self::handle_users();
        } elseif (str_contains($route, 'provinces')) {
            $data = self::handle_provinces();
        } elseif (str_contains($route, 'municipalities')) {
            $data = self::handle_municipalities();
        } elseif (str_contains($route, 'neighborhoods')) {
            $data = self::handle_neighborhoods();
        } elseif (str_contains($route, 'labels')) {
            $data = self::handle_labels();
        }

        $template->apply($data);
    }

    public function handle_users()
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

        return [
            'users' => $filteredUsers,
            'roles' => RoleUtils::getAll(),
            'default_user' => $userId,
            'default_role' => $roleId,
        ];
    }

    public function handle_provinces()
    {
        $provinces = ProvinceUtils::getAll();
        return ['provinces' => $provinces];
    }

    public function handle_municipalities()
    {
        $provinces = ProvinceUtils::getAll();
        $municipalities = MunicipalityUtils::getAll();
        return [
            'provinces' => $provinces,
            'municipalities' => $municipalities,
        ];
    }

    public function handle_neighborhoods()
    {
        $municipalities = MunicipalityUtils::getAll();
        $neighborhoods = NeighborhoodUtils::getAll();
        return [
            'municipalities' => $municipalities,
            'neighborhoods' => $neighborhoods,
        ];
    }

    public function handle_labels()
    {
        $labels = LabelUtils::getAll();
        return ['labels' => $labels];
    }
}

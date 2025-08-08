<?php

namespace App\Controllers\Super\Admin;

use App\Core\Template;
use App\Utils\Entities\UserUtils;
use App\Utils\Entities\RoleUtils;
use App\Utils\Entities\LabelUtils;
use App\Utils\Entities\ProvinceUtils;
use App\Utils\Entities\MunicipalityUtils;
use App\Utils\Entities\NeighborhoodUtils;


class HomeController
{
    public function handle(Template $template)
    {
        $template->apply([
            'users_count' => sizeof(UserUtils::getAll()),
            'roles_count' => sizeof(RoleUtils::getAll()),
            'provinces_count' => sizeof(ProvinceUtils::getAll()),
            'municipalities_count' => sizeof(MunicipalityUtils::getAll()),
            'neighborhoods_count' => sizeof(NeighborhoodUtils::getAll()),
            'labels_count' => sizeof(LabelUtils::getAll()),
        ]);
    }
}

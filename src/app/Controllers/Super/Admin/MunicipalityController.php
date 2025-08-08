<?php

namespace App\Controllers\Super\Admin;

use App\Core\Template;
use App\Utils\Entities\ProvinceUtils;
use App\Utils\Entities\MunicipalityUtils;


class MunicipalityController
{
    public function handle(Template $template)
    {
        $provinces = ProvinceUtils::getAll();
        $municipalities = MunicipalityUtils::getAll();
        $template->apply([
            'provinces' => $provinces,
            'municipalities' => $municipalities,
        ]);
    }
}

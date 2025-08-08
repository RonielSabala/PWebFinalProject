<?php

namespace App\Controllers\Super\Admin;

use App\Core\Template;
use App\Utils\Entities\ProvinceUtils;


class ProvinceController
{
    public function handle(Template $template)
    {
        $provinces = ProvinceUtils::getAll();
        $template->apply(['provinces' => $provinces]);
    }
}

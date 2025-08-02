<?php

namespace App\Controllers\Reporters;

use App\Core\Template;
use App\Utils\ProvinceUtils;
use App\Utils\LabelUtils;


class EditIncidenceController
{
    public function handle(Template $template)
    {
        $template->apply([
            'provinces' => ProvinceUtils::getAll(),
            'labels' => LabelUtils::getAll(),
        ]);
    }
}

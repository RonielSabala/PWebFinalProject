<?php

namespace App\Controllers\Super\Admin;

use App\Core\Template;
use App\Utils\Entities\MunicipalityUtils;
use App\Utils\Entities\NeighborhoodUtils;


class NeighborhoodController
{
    public function handle(Template $template)
    {

        $municipalities = MunicipalityUtils::getAll();
        $neighborhoods = NeighborhoodUtils::getAll();
        $template->apply([
            'municipalities' => $municipalities,
            'neighborhoods' => $neighborhoods,
        ]);
    }
}

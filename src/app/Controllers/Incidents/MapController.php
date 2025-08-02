<?php

namespace App\Controllers\Incidents;

use App\Core\Template;
use App\Utils\Entities\ProvinceUtils;
use App\Utils\Entities\IncidenceUtils;
use App\Utils\Entities\CommentUtils;


class MapController
{
    public function handle(Template $template)
    {
        if (($_GET['action'] ?? '') === 'showModal') {
            $comments = CommentUtils::getAllByIncidenceId($_GET['incidence_id']);
        }

        $incidents = IncidenceUtils::getAll();
        $provinces = ProvinceUtils::getAll();
        $template->apply([
            'incidents' => $incidents,
            'provinces' => $provinces,
            'comments' => $comments ?? '',
            'incidence_id'  => $_GET['incidence_id'] ?? null,
        ]);
    }
}

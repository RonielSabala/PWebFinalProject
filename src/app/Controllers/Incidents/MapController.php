<?php

namespace App\Controllers\Incidents;

use App\Core\Template;
use App\Utils\ProvinceUtils;
use App\Utils\IncidenceUtils;
use App\Utils\CommentUtils;


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

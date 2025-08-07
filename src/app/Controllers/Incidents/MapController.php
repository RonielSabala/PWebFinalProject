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
        // Manejar peticiones por GET
        if (($_GET['action'] ?? '') === 'GET') {
            $data = null;
            Template::enableJsonMode();

            // Obtener los comentarios de la incidencia seleccionada
            if (isset($_GET['incidence_id'])) {
                $incidenceId = $_GET['incidence_id'];
                $data = CommentUtils::getAllByIncidenceId($incidenceId);
            }

            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            exit;
        }

        $incidents = IncidenceUtils::getAll();
        $provinces = ProvinceUtils::getAll();
        $template->apply([
            'incidents' => $incidents,
            'provinces' => $provinces,
        ]);
    }
}

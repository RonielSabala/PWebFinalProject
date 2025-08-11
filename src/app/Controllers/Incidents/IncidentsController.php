<?php

namespace App\Controllers\Incidents;

use App\Core\Template;
use App\Utils\Entities\ProvinceUtils;
use App\Utils\Entities\IncidenceUtils;
use App\Utils\Entities\CommentUtils;


class IncidentsController
{
    public function handle(Template $template)
    {
        // Manejar peticiones por GET
        if (($_GET['action'] ?? '') === 'GET') {
            Template::enableJsonMode();
            $data = null;

            // Devolver el contenido del modal de la incidencia seleccionada
            $incidenceId = $_GET['incidence_id'] ?? '';
            if (!empty($incidenceId)) {
                // Rutas
                $relPath = 'incidents/incidence';
                $viewPath = BASE_PATH . '/public/views/' . $relPath . '.php';
                $cssPath = '/css/' . $relPath . '.css';
                $jsPath = '/js/' . $relPath . '.js';

                // Cargar el CSS
                ob_start();
                if (file_exists(BASE_PATH . '/public' . $cssPath)) {
                    echo '<link rel="stylesheet" href="' . $cssPath . '"></link>';
                }

                // Cargar la vista
                if (file_exists($viewPath)) {
                    extract([
                        'incidence' => IncidenceUtils::get($incidenceId),
                        'comments' => CommentUtils::getAllByIncidenceId($incidenceId),
                    ], EXTR_SKIP);

                    include $viewPath;
                }

                // Cargar el JS
                if (file_exists(BASE_PATH . '/public' . $jsPath)) {
                    echo '<script src="' . $jsPath . '"></s>';
                }

                $data = ob_get_clean();
            }

            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            exit;
        }

        $incidents = IncidenceUtils::getAllApproved();
        $provinces = ProvinceUtils::getAll();
        $template->apply([
            'incidents' => $incidents,
            'provinces' => $provinces,
        ]);
    }
}

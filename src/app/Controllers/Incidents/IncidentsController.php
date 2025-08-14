<?php

namespace App\Controllers\Incidents;

use App\Core\Template;
use App\Utils\Entities\ProvinceUtils;
use App\Utils\Entities\IncidenceUtils;
use App\Utils\Entities\CommentUtils;
use App\Utils\Entities\LabelUtils;


class IncidentsController
{
    public function handle(Template $template)
    {
        $basePath = BASE_PATH . '/public';

        // Manejar peticiones por GET
        if (($_GET['action'] ?? '') === 'GET') {
            Template::enableJsonMode();
            $data = null;

            // Devolver el contenido del modal de la incidencia seleccionada
            $incidenceId = $_GET['incidence_id'] ?? '';
            if (!empty($incidenceId)) {
                // Rutas
                $relPath = 'incidents/incidence';
                $viewPath = $basePath . '/views/' . $relPath . '.php';
                $cssPath = '/css/' . $relPath . '.css';
                $jsPath = '/js/' . $relPath . '.js';

                // Cargar el CSS
                ob_start();
                if (file_exists($basePath . $cssPath)) {
                    echo '<link rel="stylesheet" href="' . $cssPath . '"></link>';
                }

                // Cargar la vista
                if (file_exists($viewPath)) {
                    $incidence = IncidenceUtils::get($incidenceId);
                    $labels = LabelUtils::getAllByIncidenceId($incidenceId);
                    $comments = CommentUtils::getAllByIncidenceId($incidenceId);
                    extract([
                        'incidence' => $incidence,
                        'labels' => $labels,
                        'comments' => $comments,
                    ]);

                    include $viewPath;
                }

                // Cargar el JS
                if (file_exists($basePath . $jsPath)) {
                    echo '<script src="' . $jsPath . '"></script>';
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

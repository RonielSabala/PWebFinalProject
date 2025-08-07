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
            Template::enableJsonMode();
            $data = null;

            // Devolver el contenido del modal de la incidencia seleccionada
            $incidenceId = $_GET['incidence_id'] ?? '';
            if (!empty($incidenceId)) {
                // Rutas
                $basePath = __DIR__ . '/../../../public';
                $relPath = 'incidents/incidence';
                $viewPath = $basePath . '/views/' . $relPath . '.php';
                $cssPath = $basePath . '/css/' . $relPath . '.css';

                // Cargar el CSS
                ob_start();
                if (file_exists($cssPath)) {
                    echo '<style>' . file_get_contents($cssPath) . '</style>';
                }

                // Cargar la vista
                if (file_exists($viewPath)) {
                    extract([
                        'incidence' => IncidenceUtils::getById($incidenceId),
                        'comments' => CommentUtils::getAllByIncidenceId($incidenceId),
                    ], EXTR_SKIP);

                    include $viewPath;
                }

                $data = ob_get_clean();
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

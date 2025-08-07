<?php

namespace App\Controllers\Reporters;

use App\Core\Template;
use App\Utils\Entities\LabelUtils;
use App\Utils\Entities\ProvinceUtils;
use App\Utils\Entities\IncidenceUtils;
use App\Utils\Entities\MunicipalityUtils;
use App\Utils\Entities\NeighborhoodUtils;


class EditIncidenceController
{
    public function handle(Template $template)
    {
        // Manejar peticiones por GET
        if (($_GET['action'] ?? '') === 'GET') {
            Template::enableJsonMode();
            $data = null;

            // Obtener los municipios de la provincia seleccionada
            $provinceId = $_GET['province_id'] ?? '';
            if (!empty($provinceId)) {
                $data = MunicipalityUtils::getAllByProvinceId($provinceId);
            }

            $municipalityId = $_GET['municipality_id'] ?? '';
            // Obtener los barrios del municipio seleccionado
            if (!empty($municipalityId)) {
                $data = NeighborhoodUtils::getAllByMunicipalityId($municipalityId);
            }

            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Datos de la incidencia
            $photo_url = $_POST['photo_url'] ?? '';
            $labels = $_POST['labels'] ?? [];
            $fields = [
                $_POST['title'],
                $_POST['incidence_description'],
                $_POST['occurrence_date'],
                $_POST['latitude'],
                $_POST['longitude'],
                $_POST['n_deaths'] ?: 0,
                $_POST['n_injured'] ?: 0,
                $_POST['n_losses'] ?: 0,
                $_POST['province_id'],
                $_POST['municipality_id'] ?: null,
                $_POST['neighborhood_id'] ?: null,
                $_SESSION['user']['id'],
            ];

            // Crear incidencia
            IncidenceUtils::create($fields, $photo_url, $labels);

            // Redirigir
            header('Location: home.php');
            exit;
        }

        $template->apply([
            'provinces' => ProvinceUtils::getAll(),
            'labels' => LabelUtils::getAll(),
        ]);
    }
}

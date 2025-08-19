<?php

namespace App\Controllers\Reporters;

use App\Core\Template;
use App\Utils\Entities\LabelUtils;
use App\Utils\Entities\ProvinceUtils;
use App\Utils\Entities\IncidenceUtils;
use App\Utils\Entities\MunicipalityUtils;
use App\Utils\Entities\NeighborhoodUtils;


class ReportController
{
    public function handle(Template $template)
    {

        // Obtener incidencia
        if (!empty($_GET['id'])) {
            $incidence = IncidenceUtils::get($_GET['id']);
            if ($incidence['is_approved'] == 1) {
                header('Location: home.php'); // Volver a home
                exit();
            }
        } else {
            $incidence = null;
        }



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
            // Procesar coordenadas
            $coordinates = trim($_POST['coordinates'] ?? '');
            $coordinates = str_replace(['(', ')'], '', $coordinates);
            list($latitude, $longitude) = explode(',', $coordinates);

            // Datos de la incidencia
            $photo_url = $_POST['photo_url'] ?? '';
            $labels = $_POST['labels'] ?? [];
            $fields = [
                $_POST['title'],
                $_POST['incidence_description'],
                $_POST['occurrence_date'],
                $latitude,
                $longitude,
                $_POST['n_deaths'] ?: 0,
                $_POST['n_injured'] ?: 0,
                $_POST['n_losses'] ?: 0,
                $_POST['province_id'],
                $_POST['municipality_id'] ?: null,
                $_POST['neighborhood_id'] ?: null,
                $_SESSION['user']['id'],
            ];

            // Actualizar o crear incidencia
            if (!empty($_POST['id'])) {
                $id = $_POST['id'];
                IncidenceUtils::update($id, $fields, $photo_url, $labels);
            } else {
                IncidenceUtils::create($fields, $photo_url, $labels);
            }

            // Redirigir
            header('Location: home.php');
            exit;
        }

        $incidence = null;
        $municipality_name = null;
        $neighborhood_name = null;

        if (!empty($_GET['id'])) {
            $incidence = IncidenceUtils::get($_GET['id']);
        }

        // Formatear datos de la incidencia
        if ($incidence !== null) {
            // Combinar latitud y longitud en un mismo string
            $incidence['latitude'] = $incidence['latitude'] . ',' . $incidence['longitude'];
            $incidence['photo_urls'] = array_filter(array_map('trim', explode(',', $incidence['photo_urls'])));
            $incidence['label_ids'] = array_map('intval', explode(',', $incidence['label_ids'] ?? ''));

            // Obtener nombre del municipio y del barrio
            $municipalityId = $incidence['municipality_id'];
            $neighborhoodId = $incidence['neighborhood_id'];
            $municipality_name = ($municipalityId) ? MunicipalityUtils::get($municipalityId) : null;
            $neighborhood_name = ($neighborhoodId) ? NeighborhoodUtils::get($neighborhoodId) : null;
        }

        $template->apply([
            'provinces' => ProvinceUtils::getAll(),
            'labels' => LabelUtils::getAll(),
            'incidence' => $incidence,
            'municipality_name' => $municipality_name,
            'neighborhood_name' => $neighborhood_name,
        ]);
    }
}

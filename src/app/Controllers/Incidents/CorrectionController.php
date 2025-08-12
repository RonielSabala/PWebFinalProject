<?php

namespace App\Controllers\Incidents;

use App\Core\Template;
use App\Utils\GeneralUtils;
use App\Utils\Entities\LabelUtils;
use App\Utils\Entities\ProvinceUtils;
use App\Utils\Entities\IncidenceUtils;
use App\Utils\Entities\CorrectionUtils;
use App\Utils\Entities\MunicipalityUtils;
use App\Utils\Entities\NeighborhoodUtils;


class CorrectionController
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

            // Obtener los barrios del municipio seleccionado
            $municipalityId = $_GET['municipality_id'] ?? '';
            if (!empty($municipalityId)) {
                $data = NeighborhoodUtils::getAllByMunicipalityId($municipalityId);
            }

            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            exit;
        }

        $last_uri = GeneralUtils::getNthURI(-2);
        if (!isset($_GET['incidence_id'])) {
            GeneralUtils::showAlert('No se especificó la incidencia', 'danger', $last_uri);
            exit;
        }

        $incidenceId = $_GET['incidence_id'];
        $incidence = IncidenceUtils::get($incidenceId);
        if (!$incidence) {
            GeneralUtils::showAlert('Incidencia no encontrada', 'danger', $last_uri);
            exit;
        }

        $coordinates = $incidence['latitude'] . ', ' . $incidence['longitude'];

        // Manejar peticiones por Post
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $incidenceId = $_POST['incidence_id'];
            $userId = $_SESSION['user']['id'];

            // Formatear coordenadas
            list($latitude, $longitude) = explode(',', $coordinates);
            $latitude = trim($latitude);
            $longitude = trim($longitude);

            // Preparar datos de corrección
            $correctionData = [
                'title' => $_POST['title'],
                'description' => $_POST['incidence_description'],
                'n_deaths' => $_POST['n_deaths'],
                'n_injured' => $_POST['n_injured'],
                'n_losses' => $_POST['n_losses'],
                'latitude' => $latitude,
                'longitude' => $longitude,
                'photo_url' => $_POST['photo_url'],
                'province_id' => $_POST['province_id'],
                'municipality_id' => $_POST['municipality_id'],
                'neighborhood_id' => $_POST['neighborhood_id'],
                'labels' => isset($_POST['labels']) ? json_encode($_POST['labels']) : null,
            ];

            // Crear corrección
            if (CorrectionUtils::create($incidenceId, $userId, $correctionData)) {
                GeneralUtils::showAlert('Corrección creada con éxito!', 'success', $last_uri);
                exit;
            }

            GeneralUtils::showAlert('Error al crear la corrección', 'danger', showReturn: false);
        }

        // Llenar el formulario 
        $occurrenceDate = new \DateTime($incidence['occurrence_date']);
        $template->apply([
            'incidence' => $incidence,
            'provinces' => ProvinceUtils::getAll(),
            'municipalities' => MunicipalityUtils::getAll(),
            'neighborhoods' => NeighborhoodUtils::getAll(),
            'labels' => LabelUtils::getAll(),
            'formattedDate' => $occurrenceDate->format('Y-m-d\TH:i'),
            'coordinates' => $coordinates,
        ]);
    }
}

<?php

namespace App\Controllers\Incidents;

use App\Core\Template;
use App\Utils\Entities\CorrectionUtils;
use App\Utils\Entities\LabelUtils;
use App\Utils\Entities\ProvinceUtils;
use App\Utils\Entities\IncidenceUtils;
use App\Utils\GeneralUtils;
use App\Utils\Entities\MunicipalityUtils;
use App\Utils\Entities\NeighborhoodUtils;

class CorrectionsController
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

        if (!isset($_GET['id'])) {
            GeneralUtils::showAlert('No se especificó la incidencia', 'danger', '/incidents/list.php');
            exit;
        }

        $incidenceId = $_GET['id'];
        $incidence = IncidenceUtils::get($incidenceId);
        
        if (!$incidence) {
            GeneralUtils::showAlert('Incidencia no encontrada', 'danger', '/incidents/list.php');
            exit;
        }

        // Llenar el formulario 
        $occurrenceDate = new \DateTime($incidence['occurrence_date']);
        $coordinates = $incidence['latitude'] . ', ' . $incidence['longitude'];

        $template->apply([
            'incidence' => $incidence,
            'provinces' => ProvinceUtils::getAll(),
            'municipalities' => MunicipalityUtils::getAll(),
            'neighborhoods' => NeighborhoodUtils::getAll(),
            'labels' => LabelUtils::getAll(),
            'formattedDate' => $occurrenceDate->format('Y-m-d\TH:i'),
            'coordinates' => $coordinates,
        ]);
        
        // Manejar peticiones por Post
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $incidenceId = $_POST['incidence_id'];
            $userId = $_SESSION['user']['id'];

            // Formatear coordenadas
            list($latitude, $longitude) = explode(',', $coordinates);
            $latitude = trim($latitude);
            $longitude = trim($longitude);

            // Preparar Datos de Corrección
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

            // Crear Corrección
            if (CorrectionUtils::create($incidenceId, $userId, $correctionData)) {
                GeneralUtils::showAlert('Corrección creada con éxito', 'success', '/incidents/list.php');
            } else {
                GeneralUtils::showAlert('Error al crear la corrección', 'danger', '/incidents/list.php');
            }
        }
    }
}

    
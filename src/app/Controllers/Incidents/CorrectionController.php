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
            list($latitude, $longitude) = explode(',', $_POST['coordinates']);
            $latitude = trim($latitude);
            $longitude = trim($longitude);

            // Preparar datos de corrección
            $correctionData = [
                'n_deaths' => $_POST['n_deaths'],
                'n_injured' => $_POST['n_injured'],
                'n_losses' => $_POST['n_losses'],
                'latitude' => $latitude,
                'longitude' => $longitude,
                'province_id' => $_POST['province_id'],
                'municipality_id' => $_POST['municipality_id'] ?? '',
                'neighborhood_id' => $_POST['neighborhood_id'] ?? '',
            ];

            if (!$this->hasChanges($incidence, $correctionData)) {
                GeneralUtils::showAlert(
                    'No se detectaron cambios respecto a la incidencia original',
                    'warning',
                    $last_uri
                );
                exit;
            }

            // Crear corrección
            if (CorrectionUtils::create($incidenceId, $userId, $correctionData)) {
                GeneralUtils::showAlert('Corrección creada con éxito!', 'success', $last_uri);
                exit;
            }

            GeneralUtils::showAlert('Error al crear la corrección', 'danger', showReturn: false);
        }



        // Llenar el formulario 
        $template->apply([
            'incidence' => $incidence,
            'provinces' => ProvinceUtils::getAll(),
            'municipalities' => MunicipalityUtils::getAll(),
            'neighborhoods' => NeighborhoodUtils::getAll(),
            'coordinates' => $coordinates,
        ]);
    }
    // Método para comparar cambios
    private function hasChanges(array $original, array $correction): bool
    {
        
        // Mapeamos $original a las mismas claves que $correction
        $originalMapped = [
            'n_deaths'       => (string)($original['n_deaths'] ?? ''),
            'n_injured'      => (string)($original['n_injured'] ?? ''),
            'n_losses'       => (string)($original['n_losses'] ?? ''),
            'latitude'       => trim((string)($original['latitude'] ?? '')),
            'longitude'      => trim((string)($original['longitude'] ?? '')),
            'province_id'    => (string)($original['province_id'] ?? ''),
            'municipality_id' => (string)($original['municipality_id'] ?? ''),
            'neighborhood_id' => (string)($original['neighborhood_id'] ?? ''),
        ];
        
        // Comparar campos
        foreach ($originalMapped as $key => $value) {
            if ((string)$value !== (string)($correction[$key] ?? '')) {
                return true;
            }
        }
        return false;
    }
}

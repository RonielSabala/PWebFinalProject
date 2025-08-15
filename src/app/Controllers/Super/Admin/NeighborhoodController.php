<?php

namespace App\Controllers\Super\Admin;

use App\Core\Template;
use App\Utils\GeneralUtils;
use App\Utils\Entities\ProvinceUtils;
use App\Utils\Entities\MunicipalityUtils;
use App\Utils\Entities\NeighborhoodUtils;


class NeighborhoodController
{
    public function handle(Template $template)
    {

        // Manejar vistas
        $route = $template::$viewPath;
        if (str_contains($route, 'create')) {
            $data = self::handle_create();
        } elseif (str_contains($route, 'edit')) {
            $data = self::handle_edit();
        } elseif (str_contains($route, 'delete')) {
            $data = self::handle_delete();
        } else {
            $data = ['neighborhoods' => NeighborhoodUtils::getAll()];
        }

        if ($data === null) {
            exit;
        }

        $template->apply($data);
    }

    private function go_home_if(bool $success)
    {
        if ($success) {
            header('Location: home.php');
        }
    }

    public function handle_create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $municipality_id = $_POST["municipality_id"];
            $neighborhood_name = $_POST["neighborhood_name"];

            // Crear barrio
            self::go_home_if(NeighborhoodUtils::create($neighborhood_name, $municipality_id));
            exit;
        }

        return ['municipalities' => MunicipalityUtils::getAll()];
    }

    public function handle_edit()
    {
        if (!isset($_GET['id'])) {
            GeneralUtils::showAlert('No se especificó el barrio.');
            exit;
        }

        // Obtener barrio
        $id = $_GET['id'];
        $neighborhood = NeighborhoodUtils::get($id);
        if (!$neighborhood) {
            exit;
        }

        // Obtener municipios
        $municipality = MunicipalityUtils::get($neighborhood['municipality_id']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Datos del barrio
            $municipality['id'] = $_POST['municipality_id'];
            $neighborhood['neighborhood_name'] = $_POST['neighborhood_name'];

            // Actualizar barrio
            self::go_home_if(NeighborhoodUtils::update($id, $neighborhood['neighborhood_name'], $municipality['id']));
            exit;
        }

        return [
            'neighborhood' => $neighborhood,
            'municipalities' => MunicipalityUtils::getAll(),
            'default_municipality' => $neighborhood['municipality_id']
        ];
    }

    public function handle_delete()
    {
        if (!isset($_GET['id'])) {
            GeneralUtils::showAlert('No se especificó el barrio.');
            exit;
        }

        $id = $_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Eliminar barrio
            self::go_home_if(NeighborhoodUtils::delete($id));
            exit;
        }

        // Obtener barrio
        $neighborhood = NeighborhoodUtils::get($id);
        if (!$neighborhood) {
            exit;
        }

        $municipality = MunicipalityUtils::get($neighborhood['municipality_id']);
        return [
            'neighborhood' => $neighborhood,
            'municipality' => $municipality,
            'province' => ProvinceUtils::get($municipality['province_id']),
        ];
    }
}

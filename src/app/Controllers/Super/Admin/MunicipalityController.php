<?php

namespace App\Controllers\Super\Admin;

use App\Core\Template;
use App\Utils\GeneralUtils;
use App\Utils\Entities\MunicipalityUtils;
use App\Utils\Entities\ProvinceUtils;

class MunicipalityController
{
    public function handle(Template $template)
    {
        // Manejar vistas
        $route = $template::$viewPath;
        if (str_contains($route, 'create')) {
            $data = self::handle_create($template);
        } elseif (str_contains($route, 'edit')) {
            $data = self::handle_edit($template);
        } elseif (str_contains($route, 'delete')) {
            $data = self::handle_delete();
        } else {
            $data = ['municipalities' => MunicipalityUtils::getAll()];
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

    public function handle_create($template)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $province_id = $_POST["province_id"];
            $municipality_name = $_POST["municipality_name"];

            // Validar nombre
            if (MunicipalityUtils::getByName($municipality_name)) {
                $template->apply();
                GeneralUtils::showAlert('Ya existe un municipio con ese nombre!', 'danger', showReturn: false);
                exit;
            }

            // Crear municipio
            self::go_home_if(MunicipalityUtils::create($municipality_name, $province_id));
            exit;
        }

        return ['provinces' => ProvinceUtils::getAll()];
    }

    public function handle_edit($template)
    {
        if (!isset($_GET['id'])) {
            GeneralUtils::showAlert('No se especificó el municipio.', 'danger');
            exit;
        }

        // Obtener municipio
        $id = $_GET['id'];
        $municipality = MunicipalityUtils::get($id);
        if (!$municipality) {
            exit;
        }

        // Obtener provincia
        $province = ProvinceUtils::get($municipality['province_id']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Datos del municipio
            $province['id'] = $_POST['province_id'];
            $municipality['municipality_name'] = $_POST['municipality_name'];

            // Validar nombre
            $other_municipality = MunicipalityUtils::getByName($municipality['municipality_name']);
            if ($other_municipality && $other_municipality['id'] != $id) {
                $template->apply([
                    'municipality' => $municipality,
                    'provinces' => ProvinceUtils::getAll(),
                    'default_province' => $province['id']
                ]);

                GeneralUtils::showAlert('Ya existe un municipio con ese nombre!', 'danger', showReturn: false);
                exit;
            }

            // Actualizar municipio
            self::go_home_if(MunicipalityUtils::update($id, $municipality['municipality_name'], $province['id']));
            exit;
        }

        return [
            'municipality' => $municipality,
            'provinces' => ProvinceUtils::getAll(),
            'default_province' => $province['id']
        ];
    }

    public function handle_delete()
    {
        if (!isset($_GET['id'])) {
            GeneralUtils::showAlert('No se especificó el municipio.', 'danger');
            exit;
        }

        $id = $_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Eliminar municipio
            self::go_home_if(MunicipalityUtils::delete($id));
            exit;
        }

        // Obtener municipio
        $municipality = MunicipalityUtils::get($id);
        if (!$municipality) {
            exit;
        }

        return [
            'municipality' => $municipality,
            'province' => ProvinceUtils::get($municipality['province_id']),
        ];
    }
}

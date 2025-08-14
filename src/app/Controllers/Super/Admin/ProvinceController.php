<?php

namespace App\Controllers\Super\Admin;

use App\Core\Template;
use App\Utils\GeneralUtils;
use App\Utils\Entities\ProvinceUtils;


class ProvinceController
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
            $data = ['provinces' => ProvinceUtils::getAll()];
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
            $province_name = $_POST["province_name"];

            // Validar nombre
            if (ProvinceUtils::getByName($province_name)) {
                $template->apply();
                GeneralUtils::showAlert('Ya existe una provincia con ese nombre!', showReturn: false);
                exit;
            }

            // Crear provincia
            self::go_home_if(ProvinceUtils::create($province_name));
        }

        return [];
    }

    public function handle_edit($template)
    {
        if (!isset($_GET['id'])) {
            GeneralUtils::showAlert('No se especificó la provincia.');
            exit;
        }

        // Obtener provincia
        $id = $_GET['id'];
        $province = ProvinceUtils::get($id);
        if (!$province) {
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Datos de la provincia
            $province['province_name'] = $_POST['province_name'];

            // Validar nombre
            $other_province = ProvinceUtils::getByName($province['province_name']);
            if ($other_province && $other_province['id'] != $id) {
                $template->apply(['province' => $province]);
                GeneralUtils::showAlert('Ya existe una provincia con ese nombre!', showReturn: false);
                exit;
            }

            // Actualizar provincia
            self::go_home_if(ProvinceUtils::update($id, $province['province_name']));
            exit;
        }

        return ['province' => $province];
    }

    public function handle_delete()
    {
        if (!isset($_GET['id'])) {
            GeneralUtils::showAlert('No se especificó la provincia.');
            exit;
        }

        $id = $_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Eliminar provincia
            self::go_home_if(ProvinceUtils::delete($id));
            exit;
        }

        // Obtener provincia
        $province = ProvinceUtils::get($id);
        if (!$province) {
            exit;
        }

        return ['province' => $province];
    }
}

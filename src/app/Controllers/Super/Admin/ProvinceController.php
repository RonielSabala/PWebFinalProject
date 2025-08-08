<?php

namespace App\Controllers\Super\Admin;

use App\Core\Template;
use App\Utils\GeneralUtils;
use App\Utils\Entities\ProvinceUtils;


class ProvinceController
{
    private function go_to_home(bool $success)
    {
        if ($success) {
            header('Location: home.php');
        }
    }

    public function handle(Template $template)
    {
        $data = [];
        $route = $template::$viewPath;

        if (str_contains($route, 'create')) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $province_name = $_POST["province_name"];

                // Crear provincia
                self::go_to_home(ProvinceUtils::create($province_name));
                exit;
            }
        } elseif (str_contains($route, 'edit')) {
            if (!isset($_GET['id'])) {
                GeneralUtils::showAlert('No se especificó la provincia.', 'danger');
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
                    GeneralUtils::showAlert('Ya existe un provincia con ese nombre!', 'danger', showReturn: false);
                    exit;
                }

                // Actualizar provincia
                self::go_to_home(ProvinceUtils::update($id, $province['province_name']));
                exit;
            }

            $data = ['province' => $province];
        } elseif (str_contains($route, 'delete')) {
            if (!isset($_GET['id'])) {
                GeneralUtils::showAlert('No se especificó la provincia.', 'danger');
                exit;
            }

            $id = $_GET['id'];
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Eliminar provincia
                self::go_to_home(ProvinceUtils::delete($id));
                exit;
            }

            // Obtener provincia
            $province = ProvinceUtils::get($id);
            if (!$province) {
                exit;
            }

            $data = ['province' => $province];
        } else {
            $data = ['provinces' => ProvinceUtils::getAll()];
        }

        $template->apply($data);
    }
}

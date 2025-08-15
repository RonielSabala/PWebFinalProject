<?php

namespace App\Controllers\Super\Admin;

use App\Core\Template;
use App\Utils\GeneralUtils;
use App\Utils\Entities\LabelUtils;


class LabelController
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
            $data = ['labels' => LabelUtils::getAll()];
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
            $label_name = $_POST["label_name"];
            $icon_url = $_POST["icon_url"];

            // Validar nombre
            if (LabelUtils::getByName($label_name)) {
                $template->apply();
                GeneralUtils::showAlert('Ya existe una etiqueta con ese nombre!', showReturn: false);
                exit;
            }

            // Crear etiqueta
            self::go_home_if(LabelUtils::create($label_name, $icon_url));
        }

        return [];
    }

    public function handle_edit($template)
    {
        if (!isset($_GET['id'])) {
            GeneralUtils::showAlert('No se especificó la etiqueta.');
            exit;
        }

        // Obtener etiqueta
        $id = $_GET['id'];
        $label = LabelUtils::get($id);
        if (!$label) {
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Datos de la etiqueta
            $label['label_name'] = $_POST['label_name'];
            $label['icon_url'] = $_POST['icon_url'];

            // Validar nombre
            $other_label = LabelUtils::getByName($label['label_name']);
            if ($other_label && $other_label['id'] != $id) {
                $template->apply(['label' => $label]);
                GeneralUtils::showAlert('Ya existe una etiqueta con ese nombre!', showReturn: false);
                exit;
            }

            // Actualizar etiqueta
            self::go_home_if(LabelUtils::update($id, $label['label_name'], $label['icon_url']));
            exit;
        }

        return ['label' => $label];
    }

    public function handle_delete()
    {
        if (!isset($_GET['id'])) {
            GeneralUtils::showAlert('No se especificó la etiqueta.');
            exit;
        }

        $id = $_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Eliminar etiqueta
            self::go_home_if(LabelUtils::delete($id));
            exit;
        }

        // Obtener etiqueta
        $label = LabelUtils::get($id);
        if (!$label) {
            exit;
        }

        return ['label' => $label];
    }
}

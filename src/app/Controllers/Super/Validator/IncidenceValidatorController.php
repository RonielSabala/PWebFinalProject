<?php

namespace App\Controllers\Super\Validator;

use App\Core\Template;
use App\Utils\GeneralUtils;
use App\Utils\Entities\IncidenceUtils;

class IncidenceValidatorController
{
    public function handle(Template $template)
    {
        $route = $template::$viewPath;

        if (str_contains($route, 'approve')) {
            $data = self::handle_approve();
        } elseif (str_contains($route, 'reject')) {
            $data = self::handle_reject();
        } else {
            $data = ['incidents' => IncidenceUtils::getAllPending()];
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

    public function handle_approve()
    {
        if (!isset($_GET['id'])) {
            GeneralUtils::showAlert('No se especificó la incidencia.', 'danger');
            exit;
        }

        $id = $_GET['id'];
        $this->go_home_if(IncidenceUtils::setApproval($id, 1));
        return null;
    }

    public function handle_reject()
    {
        if (!isset($_GET['id'])) {
            GeneralUtils::showAlert('No se especificó la incidencia.', 'danger');
            exit;
        }

        $id = $_GET['id'];
        $this->go_home_if(IncidenceUtils::setApproval($id, 0));
        return null;
    }
}

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
        $this->handle_approve();
        return;
    }

    if (str_contains($route, 'reject')) {
        $this->handle_reject();
        return;
    }

    // Siempre cargar incidencias pendientes
    $pendingIncidents = IncidenceUtils::getAllPending();
    $data = [
        'incidents' => $pendingIncidents,
        'pending_incidents_count' => count($pendingIncidents)
    ];
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

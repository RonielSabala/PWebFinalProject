<?php

namespace App\Controllers\Super\Validator;

use App\Core\Template;
use App\Utils\GeneralUtils;
use App\Utils\Entities\IncidenceUtils;


class RejectIncidenceController
{
    public function handle(Template $template)
    {
        if (!isset($_GET['id'])) {
            GeneralUtils::showAlert('No se especificó la incidencia.');
            exit;
        }

        $id = $_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Eliminar incidencia
            $success = IncidenceUtils::delete($id);
            if ($success) {
                // Redirigir
                header('Location: incidence_validation.php');
            }

            exit;
        }

        // Obtener incidencia
        $incidence = IncidenceUtils::get($id);
        if (!$incidence) {
            exit;
        }

        if ($incidence['is_approved']) {
            GeneralUtils::showAlert('La incidencia ya se encuentra aprobada.');
            exit;
        }

        $template->apply(['incidence' => $incidence]);
    }
}

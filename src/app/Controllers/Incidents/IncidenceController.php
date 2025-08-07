<?php

namespace App\Controllers\Incidents;

use App\Core\Template;
use App\Utils\GeneralUtils;
use App\Utils\Entities\IncidenceUtils;
use App\Utils\Entities\CommentUtils;


class IncidenceController
{
    public function handle(Template $template)
    {
        if (!isset($_GET['id'])) {
            GeneralUtils::showAlert('No se especificó la incidencia.', 'danger');
            exit;
        }

        // Obtener incidencia
        $id = $_GET['id'];
        $incidence = IncidenceUtils::getById($id);
        if (!$incidence) {
            exit;
        }

        $comments = CommentUtils::getAllByIncidenceId($id);
        $template->apply([
            'incidence' => $incidence,
            'comments' => $comments,
        ]);
    }
}

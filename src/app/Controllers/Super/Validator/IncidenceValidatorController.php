<?php

namespace App\Controllers\Super\Validator;

use App\Core\Template;
use App\Utils\GeneralUtils;
use App\Utils\Entities\IncidenceUtils;


class IncidenceValidatorController
{
    public function handle(Template $template)
    {
        $pendingIncidents = IncidenceUtils::getAllPending();
        $template->apply([
            'incidents' => $pendingIncidents,
            'pending_incidents_count' => count($pendingIncidents)
        ]);
    }
}

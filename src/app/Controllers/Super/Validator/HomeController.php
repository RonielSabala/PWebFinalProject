<?php

namespace App\Controllers\Super\Validator;

use App\Core\Template;
use App\Utils\Entities\IncidenceUtils;
use App\Utils\Entities\CorrectionUtils;


class HomeController
{
    public function handle(Template $template)
    {
        $template->apply([
            'pending_incidents_count' => count(IncidenceUtils::getAllPending()),
            'pending_corrections_count' => count(CorrectionUtils::getAllPending()),
        ]);
    }
}

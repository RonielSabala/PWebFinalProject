<?php

namespace App\Controllers\Super\Validator;

use App\Core\Template;
use App\Utils\Entities\IncidenceUtils;


class HomeController
{
    public function handle(Template $template)
    {
        $template->apply([
            'pending_incidents_count' => count(IncidenceUtils::getAllPending())
        ]);
    }
}

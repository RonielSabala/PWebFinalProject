<?php

namespace App\Controllers\Super\Validator;

use App\Core\Template;
use App\Utils\Entities\IncidenceUtils;


class IncidenceValidationController
{
    public function handle(Template $template)
    {
        $template->apply([
            'incidents' => IncidenceUtils::getAllPending(),
        ]);
    }
}

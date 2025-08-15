<?php

namespace App\Controllers\Super\Validator;

use App\Core\Template;
use App\Utils\Entities\CorrectionUtils;


class FixIncidenceController
{
    public function handle(Template $template)
    {
        $template->apply([
            'corrections' => CorrectionUtils::getAllPending(),
        ]);
    }
}

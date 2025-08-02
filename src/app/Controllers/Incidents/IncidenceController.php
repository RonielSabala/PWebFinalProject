<?php

namespace App\Controllers\Incidents;

use App\Core\Template;


class IncidenceController
{
    public function handle(Template $template)
    {
        $template->apply();
    }
}

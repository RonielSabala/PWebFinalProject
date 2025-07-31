<?php

namespace App\Controllers\Incidents;

use App\Core\Template;


class IncidentController
{
    public function handle(Template $template, $pdo)
    {
        $template->apply();
    }
}

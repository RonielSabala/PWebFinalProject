<?php

namespace App\Controllers;

use App\Core\Template;


class IncidentController
{
    public function handle(Template $template, $pdo)
    {
        $template->apply();
    }
}

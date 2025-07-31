<?php

namespace App\Controllers\Incidents;

use App\Core\Template;


class MapController
{
    public function handle(Template $template, $pdo)
    {
        $template->apply();
    }
}

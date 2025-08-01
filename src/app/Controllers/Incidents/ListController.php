<?php

namespace App\Controllers\Incidents;

use App\Core\Template;


class ListController
{
    public function handle(Template $template)
    {
        $template->apply();
    }
}

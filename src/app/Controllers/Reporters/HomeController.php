<?php

namespace App\Controllers\Reporters;

use App\Core\Template;


class HomeController
{
    public function handle(Template $template)
    {
        $template->apply([]);
    }
}

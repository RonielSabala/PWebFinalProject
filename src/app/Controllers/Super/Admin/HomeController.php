<?php

namespace App\Controllers\Super\Admin;

use App\Core\Template;


class HomeController
{
    public function handle(Template $template)
    {
        $template->apply();
    }
}

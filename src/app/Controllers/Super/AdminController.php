<?php

namespace App\Controllers\Super;

use App\Core\Template;


class AdminController
{
    public function handle(Template $template)
    {
        $template->apply();
    }
}

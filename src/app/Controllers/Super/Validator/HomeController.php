<?php

namespace App\Controllers\Super\Validator;

use App\Core\Template;


class HomeController
{
    public function handle(Template $template)
    {
        $template->apply();
    }
}

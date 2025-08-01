<?php

namespace App\Controllers\Super;

use App\Core\Template;


class ValidatorController
{
    public function handle(Template $template)
    {
        $template->apply();
    }
}

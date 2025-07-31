<?php

namespace App\Controllers;

use App\Core\Template;


class ValidatorController
{
    public function handle(Template $template, $pdo)
    {
        $template->apply();
    }
}

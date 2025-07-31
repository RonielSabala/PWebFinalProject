<?php

namespace App\Controllers\Super;

use App\Core\Template;


class AdminController
{
    public function handle(Template $template, $pdo)
    {
        $template->apply();
    }
}

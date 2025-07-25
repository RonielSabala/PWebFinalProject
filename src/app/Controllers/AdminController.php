<?php

namespace App\Controllers;

use App\Core\Template;


class AdminController
{
    public function handle(Template $template, $pdo)
    {
        $template->apply([
            'pdo' => $pdo,
        ]);
    }
}

<?php

namespace App\Controllers;

use App\Core\Template;


class ListController
{
    public function handle(Template $template, $pdo)
    {
        $template->apply([
            'pdo' => $pdo,
        ]);
    }
}

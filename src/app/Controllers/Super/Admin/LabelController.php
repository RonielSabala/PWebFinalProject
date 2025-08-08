<?php

namespace App\Controllers\Super\Admin;

use App\Core\Template;
use App\Utils\Entities\LabelUtils;


class LabelController
{
    public function handle(Template $template)
    {
        $labels = LabelUtils::getAll();
        $template->apply(['labels' => $labels]);
    }
}

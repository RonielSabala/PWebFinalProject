<?php

namespace App\Controllers\Reporters;

use App\Core\Template;
use App\Utils\Entities\IncidenceUtils;


class HomeController
{
    public function handle(Template $template)
    {
        $reporter_id = $_SESSION["user"]["id"];
        $incidents = IncidenceUtils::getByReporterId($reporter_id);
        $template->apply(["incidents" => $incidents]);
    }
}

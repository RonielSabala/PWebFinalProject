<?php

namespace App\Controllers\Reporters;

use App\Core\Template;
use App\Utils\Entities\IncidenceUtils;


class HomeController
{
    public function handle(Template $template)
    {
        $reporterId = $_SESSION['user']['id'];
        $incidents = IncidenceUtils::getAllByReporterId($reporterId);
        $template->apply(['incidents' => $incidents]);
    }
}

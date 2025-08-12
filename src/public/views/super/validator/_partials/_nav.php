<?php

use App\Utils\GeneralUtils;
?>

<div class="divMenu">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="<?= GeneralUtils::getActiveClass('validator') ?>"
                href="/super/validator/home.php">Inicio</a>
        </li>

        <li class="nav-item">
            <a class="<?= GeneralUtils::getActiveClass('incidents') ?>"
                href="/incidents/map.php">Mapa</a>
        </li>

        <li class="nav-item">
            <a class="<?= GeneralUtils::getActiveClass('controller') ?>"
                href="/reporters/home.php">Reportes</a>
        </li>
    </ul>


</div>
<div class="view-content">
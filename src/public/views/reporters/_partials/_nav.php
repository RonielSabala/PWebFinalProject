<?php

use App\Utils\GeneralUtils;
?>

<div class="divMenu">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="<?= GeneralUtils::getActiveClass('controller') ?>"
                href="/reporters/home.php">Reportes</a>
        </li>

        <li class="nav-item">
            <a class="<?= GeneralUtils::getActiveClass('validator') ?>"
                href="/super/validator/home.php">Validar reportes</a>
        </li>
        
        <li class="nav-item">
            <a class="<?= GeneralUtils::getActiveClass('incidents') ?>"
                href="/incidents/map.php">Mapa</a>
        </li>

        
        
        <?= GeneralUtils::setLogoutButton(); ?>
    </ul>
</div>
<div class="view-content">
    <!-- View content here -->
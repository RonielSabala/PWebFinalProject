<?php

use App\Utils\GeneralUtils;
?>

<div class="divMenu">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="<?= GeneralUtils::getActiveClass('home'); ?>"
                href="/home.php">Inicio</a>
        </li>
        <li class="nav-item">
            <a class="<?= GeneralUtils::getActiveClass('incidence'); ?>"
                href="">Incidencias</a>
        </li>
        <?= GeneralUtils::setLogoutButton(); ?>
    </ul>
</div>
<div class="view-content">
    <!-- View content here -->
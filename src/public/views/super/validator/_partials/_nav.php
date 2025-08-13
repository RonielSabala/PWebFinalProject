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
            <a class="<?= GeneralUtils::getActiveClass('validate_incidence') ?>"
                href="/super/validator/validate_incidence.php">Validar incidencias</a>
        </li>
        <?= GeneralUtils::setLogoutButton(); ?>
    </ul>
</div>
<div class="view-content">
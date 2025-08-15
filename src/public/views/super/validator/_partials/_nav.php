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
            <a class="<?= GeneralUtils::getActiveClass('incidence_validation') ?>"
                href="/super/validator/incidence_validation.php">Validar incidencias</a>
        </li>
        <li class="nav-item">
            <a class="<?= GeneralUtils::getActiveClass('correction_validation') ?>"
                href="/super/validator/correction_validation.php">Validar correcciones</a>
        </li>
        <?= GeneralUtils::setLogoutButton(); ?>
    </ul>
</div>
<div class="view-content">
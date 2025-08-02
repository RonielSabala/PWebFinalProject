<?php

use App\Utils\GenericUtils;
?>

<div class="divMenu">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="<?= GenericUtils::getActiveClass('home'); ?>"
                href="/home.php">Inicio</a>
        </li>
        <li class="nav-item">
            <a class="<?= GenericUtils::getActiveClass('incidence'); ?>"
                href="">Incidencias</a>
        </li>
        <?= GenericUtils::setLogoutButton(); ?>
    </ul>
</div>
<div class="view-content">
    <!-- View content here -->
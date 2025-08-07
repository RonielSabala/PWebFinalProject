<?php

use App\Utils\GeneralUtils;

$uri = GeneralUtils::getURI();
$route = GeneralUtils::splitURI($uri)[0];
?>

<div class="divMenu">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="<?= GeneralUtils::getActiveClass('home'); ?>"
                href="/home.php">Inicio</a>
        </li>
        <?php if ($route === 'incidents'): ?>
            <li class="nav-item">
                <a class="<?= GeneralUtils::getActiveClass('incidence'); ?>"
                    href="">Incidencias</a>
            </li>
        <?php endif; ?>
        <?= GeneralUtils::setLogoutButton(); ?>
    </ul>
</div>
<div class="view-content">
    <!-- View content here -->
<?php

use App\Utils\GeneralUtils;

$uri = GeneralUtils::getURI();
[$route, $view] = GeneralUtils::splitURI($uri);
[$last_route, $last_view] = GeneralUtils::splitURI(GeneralUtils::getNthURI(-2));
$show_incidence = $view === 'incidence.php';
?>

<div class="divMenu">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="<?= GeneralUtils::getActiveClass('home'); ?>"
                href="/home.php">Inicio</a>
        </li>
        <?php if (($show_incidence ? substr($last_route, 1) : $route) === 'incidents'): ?>
            <li class="nav-item">
                <a class="<?= GeneralUtils::getActiveClass('incidents'); ?>"
                    href="<?= $show_incidence ? explode('?', $last_view)[0] : '' ?>">Incidencias</a>
            </li>
        <?php endif; ?>
        <?php if ($show_incidence): ?>
            <li class="nav-item">
                <a class="<?= GeneralUtils::getActiveClass('incidence'); ?>"
                    href="">Incidencia</a>
            </li>
        <?php endif; ?>
        <?= GeneralUtils::setLogoutButton(); ?>
    </ul>
</div>
<div class="view-content">
    <!-- View content here -->
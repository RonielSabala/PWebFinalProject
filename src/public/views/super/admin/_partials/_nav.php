<?php

use App\Utils\GeneralUtils;
?>

<div class="container">
    <div class="divMenu">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="<?= GeneralUtils::getActiveClass('admin') ?>"
                    href="/super/admin/home.php">Inicio</a>
            </li>
            <li class="nav-item">
                <a class="<?= GeneralUtils::getActiveClass('users') ?>"
                    href="/super/admin/users.php">Usuarios</a>
            </li>
            <li class="nav-item">
                <a class="<?= GeneralUtils::getActiveClass('provinces') ?>"
                    href="/super/admin/provinces/home.php">Provincias</a>
            </li>
            <li class="nav-item">
                <a class="<?= GeneralUtils::getActiveClass('municipalities') ?>"
                    href="/super/admin/municipalities/home.php">Municipios</a>
            </li>
            <li class="nav-item">
                <a class="<?= GeneralUtils::getActiveClass('neighborhoods') ?>"
                    href="/super/admin/neighborhoods/home.php">Barrios</a>
            </li>
            <li class="nav-item">
                <a class="<?= GeneralUtils::getActiveClass('labels') ?>"
                    href="/super/admin/labels/home.php">Etiquetas</a>
            </li>
        </ul>
    </div>
    <div class="view-content">
        <!-- View content here -->
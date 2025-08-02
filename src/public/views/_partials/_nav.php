<?php

use App\Utils\GenericUtils;
?>

<div class="divMenu">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="<?= GenericUtils::getActiveClass('incidence') ?>"
                href="/incidence.php">Inicio</a>
        </li>
        <li class="nav-item ms-auto">
            <a
                href="logout.php"
                class="btn btn-outline-danger btn-sm">
                Cerrar sesión
            </a>
        </li>
    </ul>
</div>
<div class="view-content">
    <!-- View content here -->
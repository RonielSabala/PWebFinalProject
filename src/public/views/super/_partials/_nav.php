<?php

use App\Utils\GeneralUtils;
?>

<div class="divMenu">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="<?= GeneralUtils::getActiveClass('validator') ?>"
                href="/super/validator.php">Validador</a>
        </li>
        <li class="nav-item">
            <a class="<?= GeneralUtils::getActiveClass('admin') ?>"
                href="/super/admin.php">Administrador</a>
        </li>
        <?= GeneralUtils::setLogoutButton(); ?>
    </ul>
</div>
<div class="view-content">
    <!-- View content here -->
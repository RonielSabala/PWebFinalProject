<?php

use App\Utils\GenericUtils;
?>

<div class="divMenu">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="<?= GenericUtils::getActiveClass('validator') ?>"
                href="/super/validator.php">Validador</a>
        </li>
        <li class="nav-item">
            <a class="<?= GenericUtils::getActiveClass('admin') ?>"
                href="/super/admin.php">Administrador</a>
        </li>
        <?= GenericUtils::setLogoutButton(); ?>
    </ul>
</div>
<div class="view-content">
    <!-- View content here -->
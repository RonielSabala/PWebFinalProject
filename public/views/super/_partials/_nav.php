<?php

use App\Helpers\Utils;
?>

<div class="divMenu">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="<?= Utils::getActiveClass('home') ?>"
                href="/validator.php">Validador</a>
        </li>
        <li class="nav-item">
            <a class="<?= Utils::getActiveClass('home') ?>"
                href="/admin.php">Administrador</a>
        </li>
    </ul>
</div>
<div class="view-content">
    <!-- View content here -->
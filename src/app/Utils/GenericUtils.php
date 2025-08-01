<?php

namespace App\Utils;


class GenericUtils
{
    public static function getActiveClass(string $page): string
    {
        $current = defined('CURRENT_PAGE') ? CURRENT_PAGE : '';
        return 'custom-link nav-link' . ($current === $page ? ' active' : '');
    }

    public static function showAlert(
        string $message,
        string $type = 'success',
        string $returnRoute = 'index.php',
        bool $showReturn = true
    ) {
        echo "
        <div class='text-center'>
            <div class='alert alert-$type'>$message</div>";
        if ($showReturn) {
            echo "<a href='$returnRoute' class='btn btn-primary'>Volver</a>";
        }
        echo "</div>";
    }
}

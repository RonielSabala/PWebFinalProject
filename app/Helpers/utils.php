<?php

namespace App\Helpers;

class Utils
{
    public static function getActiveClass(string $page): string
    {
        $current = defined('CURRENT_PAGE') ? CURRENT_PAGE : '';
        return 'custom-link nav-link' . ($current === $page ? ' active' : '');
    }

    public static function showAlert(string $message, string $type = 'success', string $returnRoute = 'home.php'): void
    {
        echo "
        <div class='text-center'>
            <div class='alert alert-$type'>$message</div>
            <a href='$returnRoute' class='btn btn-primary'>Volver</a>
        </div>
        ";
    }
}

<?php

namespace App\Utils;


class GeneralUtils
{
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

    public static function getActiveClass(string $page): string
    {
        $current = defined('CURRENT_PAGE') ? CURRENT_PAGE : '';
        return 'custom-link nav-link' . ($current === $page ? ' active' : '');
    }

    public static function setLogoutButton()
    {
        echo '
        <li class="nav-item ms-auto">
            <a
                href="/auth/logout.php"
                class="btn btn-outline-danger btn-sm">
                Cerrar sesión
            </a>
        </li>
        ';
    }

    public static function getURI(): string
    {
        return trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    }

    public static function splitURI($uri)
    {
        $uri_parts = explode('/', $uri);
        if (count($uri_parts) == 1) {
            return ['', $uri];
        }

        $uri = implode('/', array_slice($uri_parts, 0, -1));
        $view = end($uri_parts);
        return [$uri, $view];
    }
}

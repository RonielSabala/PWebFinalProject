<?php

namespace App\Utils;

use DateTime;


class GeneralUtils
{
    private static $wellKnownUri = '/.well-known/appspecific/com.chrome.devtools.json';

    public static function showAlert(
        string $message,
        string $type = 'danger',
        string $returnRoute = '',
        bool $showReturn = true
    ) {
        if ($showReturn && empty($returnRoute)) {
            $returnRoute = GeneralUtils::getNthURI(-2);
        }

        echo "
        <div class='text-center mt-2'>
            <div class='alert alert-$type'>$message</div>";
        if ($showReturn) {
            echo "<a href='$returnRoute' class='btn btn-primary mb-4'>Volver</a>";
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

    public static function showNoData($entities, string $entities_name)
    {
        if ($entities) {
            return;
        }

        echo '
        <div id="noData" class="no-data">
            <i class="bi bi-inbox-fill fs-1 mb-2"></i>
            <div>No se encontraron ' . $entities_name . '.</div>
        </div>
        ';
    }

    public static function getURI(): string
    {
        $uri = $_SERVER['REQUEST_URI'];

        // Guardar la URI en el historial
        $length = count($_SESSION['uri_history']);
        if ($length === 0) {
            $_SESSION['uri_history'][] = $uri;
        } elseif ($uri !== self::$wellKnownUri) {
            [$current_uri, $current_view] = self::splitURI($uri);
            [$last_uri, $last_view] = self::splitURI(self::getNthURI(-1));

            $current = $current_uri . '/' . explode('?', $current_view)[0];
            $last = $last_uri . '/' . explode('?', $last_view)[0];
            if ($current !== $last) {
                $_SESSION['uri_history'][] = $uri;
                $_SESSION['uri_history'] = array_slice($_SESSION['uri_history'], -5);
            }
        }

        return trim(parse_url($uri, PHP_URL_PATH), '/');
    }

    public static function getNthURI(int $n)
    {
        $length = count($_SESSION['uri_history']);
        if ($n < 0) {
            $n += $length;
        }

        $last_uri = '';
        if ($length > abs($n)) {
            $last_uri = $_SESSION['uri_history'][$n];
        }

        return $last_uri;
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

    public static function formatDate($date)
    {
        return (new DateTime($date))->format('d/m/Y H:i');
    }
}

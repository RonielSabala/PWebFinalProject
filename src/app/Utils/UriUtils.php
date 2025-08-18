<?php

namespace App\Utils;


class UriUtils
{
    private static $wellKnownUri = '/.well-known/appspecific/com.chrome.devtools.json';

    public static function split($uri)
    {
        $uri_parts = explode('/', $uri);
        if (count($uri_parts) == 1) {
            return ['', $uri];
        }

        $uri = implode('/', array_slice($uri_parts, 0, -1));
        $view = end($uri_parts);
        return [$uri, $view];
    }

    public static function get(): string
    {
        $uri = $_SERVER['REQUEST_URI'];

        // Guardar la URI en el historial
        $length = count($_SESSION['uri_history']);
        if ($length === 0) {
            $_SESSION['uri_history'][] = $uri;
        } elseif ($uri !== self::$wellKnownUri) {
            [$current_uri, $current_view] = self::split($uri);
            [$last_uri, $last_view] = self::split(self::getNthUri(-1));

            $current = $current_uri . '/' . explode('?', $current_view)[0];
            $last = $last_uri . '/' . explode('?', $last_view)[0];
            if ($current !== $last) {
                $_SESSION['uri_history'][] = $uri;
                $_SESSION['uri_history'] = array_slice($_SESSION['uri_history'], -5);
            }
        }

        return trim(parse_url($uri, PHP_URL_PATH), '/');
    }

    public static function getNthUri(int $n)
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
}

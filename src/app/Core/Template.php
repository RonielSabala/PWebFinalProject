<?php

namespace App\Core;


class Template
{
    static private $basePath = __DIR__ . "/../../public";
    static private $viewsPath = __DIR__ . "/../../public/views";
    static public $partialsPath = '';
    static public $viewPath = '';
    private static bool $jsonMode = false;

    public static function enableJsonMode()
    {
        self::$jsonMode = true;
        ob_end_clean();
        header('Content-Type: application/json; charset=utf-8');
    }

    private static function findPartialsPath()
    {
        $relative = trim(self::$partialsPath ?? '', '/');
        $parts = $relative === '' ? [] : explode('/', $relative);

        // Recorremos desde el path completo hacia arriba hasta 0 niveles
        $found = false;
        for ($i = count($parts); $i >= 0; $i--) {
            $sub = $i > 0 ? implode('/', array_slice($parts, 0, $i)) : '';
            $try = self::$viewsPath . ($sub !== '' ? '/' . $sub : '') . '/_partials';

            if (is_dir($try)) {
                self::$partialsPath = $try;
                $found = true;
                break;
            }
        }

        // Partials por defecto
        if (!$found) {
            self::$partialsPath = self::$viewsPath . '/_partials';
        }
    }

    private function includePartialView(string $partialView)
    {
        $file_path = self::$partialsPath . $partialView;
        if (!file_exists($file_path)) {
            $file_path = self::$viewsPath . '/_partials/' . $partialView;
        }

        include $file_path;
    }

    public function __construct()
    {
        if (self::$jsonMode) {
            return;
        }

        $path = self::$partialsPath;

        // Incluir los partials
        self::findPartialsPath();
        self::includePartialView('/_header.php');
        self::includePartialView('/_nav.php');

        // Incluir el CSS de las partials solo si existe
        $css_path = self::$basePath . '/css/' . $path . '/main.css';
        if (file_exists($css_path)) {
            echo '
            <link rel="stylesheet" href="/css/' . $path . '/main.css">
            ';
        }
    }

    public function __destruct()
    {
        if (self::$jsonMode) {
            return;
        }

        self::includePartialView('/_footer.php');
    }

    public function apply(array $data = [])
    {
        if (self::$jsonMode) {
            return;
        }

        $path = self::$viewPath;

        // Incluir el CSS de la vista solo si existe
        $css_path = self::$basePath . '/css/' . $path . '.css';
        if (file_exists($css_path)) {
            echo '
            <link rel="stylesheet" href="/css/' . $path . '.css">
            ';
        }

        // Incluir la vista solo si existe
        $file_path = self::$viewsPath . '/' . $path . '.php';
        if (file_exists($file_path)) {
            extract($data, EXTR_SKIP);
            include $file_path;
        }

        // Incluir el js de la vista solo si existe
        $js_path = self::$basePath . '/js/' . $path . '.js';
        if (file_exists($js_path)) {
            echo '
            <script src="/js/' . $path . '.js"></script>
            ';
        }
    }
}

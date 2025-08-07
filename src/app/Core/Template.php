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

    private function include_partial_if_exists(string $partialView)
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

        // Obtener la ruta a las vistas parciales
        $path = self::$partialsPath;
        self::$partialsPath = self::$viewsPath . '/' . $path . '/_partials';
        if (!is_dir(self::$partialsPath)) {
            self::$partialsPath = self::$viewsPath . '/_partials';
        }

        // Incluir los partials
        self::include_partial_if_exists('/_header.php');
        self::include_partial_if_exists('/_nav.php');

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

        self::include_partial_if_exists('/_footer.php');
    }

    public function apply(array $data = [])
    {
        if (self::$jsonMode) {
            return;
        }

        // Incluir el CSS de la vista solo si existe
        $path = self::$viewPath;
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

<?php

namespace App\Core;


class Template
{
    static private $basePath = __DIR__ . "/../../public/views";
    static public $partialsPath = '';
    static public $viewPath = '';
    private static bool $jsonMode = false;

    public static function enableJsonMode()
    {
        self::$jsonMode = true;
        ob_end_clean();
        header('Content-Type: application/json; charset=utf-8');
    }

    private function include_partial(string $partialView)
    {
        $file_path = self::$partialsPath . $partialView;
        if (file_exists($file_path)) {
            include $file_path;
        } else {
            # Fallback
            include self::$basePath . '/_partials/' . $partialView;
        }
    }

    public function __construct()
    {
        if (self::$jsonMode) {
            return;
        }

        $path = self::$partialsPath;

        // Obtener la ruta a las vistas parciales
        self::$partialsPath = self::$basePath . '/' . $path . '/_partials';
        if (!is_dir(self::$partialsPath)) {
            self::$partialsPath = self::$basePath . '/_partials';
        }

        self::include_partial('/_header.php');
        self::include_partial('/_nav.php');

        // Incluir el CSS de las partials
        echo '
        <link rel="stylesheet" href="/css/' . $path . '/main.css">
        ';
    }

    public function __destruct()
    {
        if (self::$jsonMode) {
            return;
        }

        self::include_partial('/_footer.php');
    }

    public function apply(array $data = [])
    {
        if (self::$jsonMode) {
            return;
        }

        // Incluir el CSS de la vista
        echo '
        <link rel="stylesheet" href="/css/' . self::$viewPath . '.css">
        ';

        // Incluir la vista solo si existe
        $file_path = self::$basePath . '/' . self::$viewPath . '.php';
        if (file_exists($file_path)) {
            extract($data, EXTR_SKIP);
            include $file_path;
        }

        // Incluir el script.js al final
        echo '
        <script src="/js/' . self::$viewPath . '.js"></script>
        ';
    }
}

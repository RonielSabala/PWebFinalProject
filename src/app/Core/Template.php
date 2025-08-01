<?php

namespace App\Core;


class Template
{
    static public $viewPath = '';
    static public $partialsPath = '';
    static private $basePath = __DIR__ . "/../../public/views";

    private function include_partial(string $partialView)
    {
        $partial_path = self::$partialsPath . $partialView;
        if (file_exists($partial_path)) {
            include $partial_path;
        }
    }

    public function __construct()
    {
        // Obtener la ruta a las vistas parciales
        self::$partialsPath = self::$basePath . '/' . self::$partialsPath . '/_partials';
        if (!is_dir(self::$partialsPath)) {
            self::$partialsPath = self::$basePath . '/_partials';
        }

        self::include_partial('/_header.php');
        self::include_partial('/_nav.php');
    }

    public function __destruct()
    {
        self::include_partial('/_footer.php');
    }

    public function apply(array $data = [])
    {
        // Incluir el CSS de la vista
        $view = self::$viewPath;
        echo '
        <link rel="stylesheet" href="/css/' . $view . '.css">
        ';

        extract($data, EXTR_SKIP);
        include self::$basePath . '/' . $view . '.php';
    }
}

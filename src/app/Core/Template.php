<?php

namespace App\Core;


class Template
{
    static private $viewsPath = __DIR__ . "/../../public/views";
    static public $partialsPath = '';
    static public $viewPath = '';

    public function apply(array $data = [])
    {
        // Incluir el CSS de la vista
        echo '
        <link rel="stylesheet" href="/css/' . self::$viewPath . '.css">
        ';

        extract($data, EXTR_SKIP);
        include self::$viewsPath . '/' . self::$viewPath . '.php';
    }

    public function __construct()
    {
        // Obtener la ruta a las vistas parciales
        self::$partialsPath = self::$viewsPath . '/' . self::$partialsPath . '/_partials';
        if (!is_dir(self::$partialsPath)) {
            self::$partialsPath = self::$viewsPath . '/_partials';
        }

        include self::$partialsPath . '/_header.php';
        include self::$partialsPath . '/_nav.php';
    }

    public function __destruct()
    {
        include self::$partialsPath . '/_footer.php';
    }
}

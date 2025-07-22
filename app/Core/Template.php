<?php

namespace App\Core;


class Template
{
    static private $views_path = "/../../public/views";

    public function apply(string $viewName, array $data = [])
    {
        echo '
        <link rel="stylesheet" href="/css/' . $viewName . '.css">
        ';

        extract($data, EXTR_SKIP);
        include __DIR__ . self::$views_path . '/' . $viewName . '.php';
    }

    public function __construct()
    {
        $partials = __DIR__ . self::$views_path . '/_partials';
        include $partials . '/_header.php';
        include $partials . '/_nav.php';
    }

    public function __destruct()
    {
        include __DIR__ . self::$views_path . '/_partials/_footer.php';
    }
}

<?php
const BASE_PATH = __DIR__ . '/../';
require_once BASE_PATH . '/vendor/autoload.php';
require_once BASE_PATH . '/config/db_config.php';

use App\Core\Router;


$router = new Router();
$router->dispatch();

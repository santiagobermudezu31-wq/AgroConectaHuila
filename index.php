<?php
declare(strict_types=1);

require __DIR__ . '/config/bootstrap.php';

use App\Core\Router;

$router = new Router();

require __DIR__ . '/routes/web.php';
require __DIR__ . '/routes/api.php';

$router->dispatch(
    $_SERVER['REQUEST_METHOD'] ?? 'GET',
    parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/'
);
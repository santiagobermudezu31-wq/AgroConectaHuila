<?php
declare(strict_types=1);

use App\Controllers\AuthController;
use App\Controllers\CategoryController;
use App\Controllers\ProductController;

$router->post('/api/auth/register', [AuthController::class, 'register']);
$router->post('/api/auth/login',    [AuthController::class, 'login']);
$router->post('/api/auth/logout',   [AuthController::class, 'logout']);

$router->get('/api/products',      [ProductController::class, 'index']);
$router->get('/api/products/{id}', [ProductController::class, 'show']);

$router->get('/api/categories', [CategoryController::class, 'apiList']);
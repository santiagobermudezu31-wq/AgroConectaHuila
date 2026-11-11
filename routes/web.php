<?php
declare(strict_types=1);

use App\Controllers\AdminController;
use App\Controllers\AuthController;
use App\Controllers\CatalogController;
use App\Controllers\HomeController;
use App\Controllers\ProducerController;
use App\Controllers\ProductPublicController;
use App\Middleware\AuthMiddleware;
use App\Middleware\RoleMiddleware;

$router->get('/',          [HomeController::class, 'index']);
$router->get('/catalogo',  [CatalogController::class, 'index']);
$router->get('/producto/{id}', [ProductPublicController::class, 'show']);

$router->get('/registro',  [AuthController::class, 'showRegister']);
$router->get('/login',     [AuthController::class, 'showLogin']);
$router->post('/logout',   [AuthController::class, 'logout']);

// Panel productor
$router->get('/panel',                    [ProducerController::class, 'dashboard'],     [AuthMiddleware::class]);
$router->get('/panel/perfil',             [ProducerController::class, 'profileForm'],   [AuthMiddleware::class]);
$router->post('/panel/perfil',            [ProducerController::class, 'profileSave'],   [AuthMiddleware::class]);
$router->get('/panel/publicaciones',      [ProducerController::class, 'publications'],  [AuthMiddleware::class]);
$router->get('/panel/nueva',              [ProducerController::class, 'newProduct'],    [AuthMiddleware::class]);
$router->post('/panel/nueva',             [ProducerController::class, 'storeProduct'],  [AuthMiddleware::class]);
$router->get('/panel/editar/{id}',        [ProducerController::class, 'editProduct'],   [AuthMiddleware::class]);
$router->post('/panel/editar/{id}',       [ProducerController::class, 'updateProduct'], [AuthMiddleware::class]);
$router->post('/panel/retirar/{id}',      [ProducerController::class, 'withdraw'],      [AuthMiddleware::class]);

// Admin
$router->get('/admin',                        [AdminController::class, 'dashboard'],       [AuthMiddleware::class, RoleMiddleware::class]);
$router->get('/admin/productores',            [AdminController::class, 'producers'],       [AuthMiddleware::class, RoleMiddleware::class]);
$router->post('/admin/productores/{id}/toggle',[AdminController::class, 'toggleProducer'],[AuthMiddleware::class, RoleMiddleware::class]);
$router->get('/admin/productos',              [AdminController::class, 'products'],        [AuthMiddleware::class, RoleMiddleware::class]);
$router->post('/admin/productos/{id}/aprobar',[AdminController::class, 'approve'],         [AuthMiddleware::class, RoleMiddleware::class]);
$router->post('/admin/productos/{id}/rechazar',[AdminController::class, 'reject'],         [AuthMiddleware::class, RoleMiddleware::class]);
$router->get('/admin/categorias',             [AdminController::class, 'categories'],      [AuthMiddleware::class, RoleMiddleware::class]);
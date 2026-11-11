<?php
declare(strict_types=1);

namespace App\Middleware;

use App\Helpers\Response;

class AuthMiddleware
{
    public function handle(): bool
    {
        if (empty($_SESSION['usuario_id'])) {
            if (str_starts_with($_SERVER['REQUEST_URI'] ?? '', '/api/')) {
                Response::error('No autenticado.', 401);
            } else {
                header('Location: ' . (getenv('APP_URL') ?: '') . '/login');
            }
            return false;
        }
        return true;
    }
}
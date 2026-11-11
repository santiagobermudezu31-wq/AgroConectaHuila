<?php
declare(strict_types=1);

namespace App\Middleware;

use App\Helpers\Response;

class RoleMiddleware
{
    public function handle(): bool
    {
        if (($_SESSION['rol'] ?? '') !== 'administrador') {
            if (str_starts_with($_SERVER['REQUEST_URI'] ?? '', '/api/')) {
                Response::error('Acceso denegado.', 403);
            } else {
                http_response_code(403);
                echo '<h1>403 — Acceso denegado</h1>';
            }
            return false;
        }
        return true;
    }
}
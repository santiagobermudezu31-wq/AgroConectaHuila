<?php
declare(strict_types=1);

namespace App\Middleware;

use App\Helpers\Response;
use App\Helpers\Security;

class CsrfMiddleware
{
    public function handle(): bool
    {
        $token = $_POST['_csrf'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
        if (!Security::csrfVerify($token)) {
            Response::error('Token CSRF inválido.', 419);
            return false;
        }
        return true;
    }
}
<?php
declare(strict_types=1);

namespace App\Helpers;

class Security
{
    public static function csrfToken(): string
    {
        if (empty($_SESSION['_csrf'])) {
            $_SESSION['_csrf'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['_csrf'];
    }

    public static function csrfVerify(?string $token): bool
    {
        return !empty($_SESSION['_csrf']) && is_string($token)
            && hash_equals($_SESSION['_csrf'], $token);
    }

    public static function e(?string $v): string
    {
        return htmlspecialchars((string)$v, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    public static function isLoggedIn(): bool
    {
        return !empty($_SESSION['usuario_id']);
    }

    public static function role(): ?string
    {
        return $_SESSION['rol'] ?? null;
    }

    public static function rateLimited(string $key): bool
    {
        $cfg = require __DIR__ . '/../../config/security.php';
        $now = time();
        $data = $_SESSION['_rate'][$key] ?? ['count' => 0, 'start' => $now];
        if ($now - $data['start'] > $cfg['login_window']) {
            $data = ['count' => 0, 'start' => $now];
        }
        $data['count']++;
        $_SESSION['_rate'][$key] = $data;
        return $data['count'] > $cfg['max_login_attempts'];
    }
}
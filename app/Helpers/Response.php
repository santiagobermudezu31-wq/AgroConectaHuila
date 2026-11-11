<?php
declare(strict_types=1);

namespace App\Helpers;

class Response
{
    public static function json(mixed $data, int $code = 200): void
    {
        http_response_code($code);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    public static function success(string $msg, mixed $data = null, int $code = 200): void
    {
        self::json(['success' => true, 'message' => $msg, 'data' => $data], $code);
    }

    public static function error(string $msg, int $code = 400, mixed $errors = null): void
    {
        self::json(['success' => false, 'message' => $msg, 'errors' => $errors], $code);
    }
}
<?php
declare(strict_types=1);

namespace App\Helpers;

class Validator
{
    public static function email(string $e): bool
    {
        return filter_var($e, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function phone(string $p): bool
    {
        return (bool)preg_match('/^[0-9+\s()-]{7,20}$/', $p);
    }
}
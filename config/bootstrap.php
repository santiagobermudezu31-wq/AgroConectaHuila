<?php
declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', getenv('APP_ENV') === 'production' ? '0' : '1');

function loadEnv(string $path): void
{
    if (!is_file($path)) return;
    foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#')) continue;
        [$k, $v] = array_pad(explode('=', $line, 2), 2, '');
        $k = trim($k);
        $v = trim($v, " \t\n\r\0\x0B\"'");
        if ($k !== '' && getenv($k) === false) {
            putenv("{$k}={$v}");
            $_ENV[$k] = $v;
        }
    }
}
loadEnv(__DIR__ . '/../.env');

spl_autoload_register(function (string $class): void {
    if (!str_starts_with($class, 'App\\')) return;
    $rel  = substr($class, 4);
    $file = __DIR__ . '/../app/' . str_replace('\\', '/', $rel) . '.php';
    if (is_file($file)) require_once $file;
});

require_once __DIR__ . '/database.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_name(getenv('SESSION_NAME') ?: 'AGROCONECTA_SESSID');
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'secure'   => getenv('APP_ENV') === 'production',
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

date_default_timezone_set('America/Bogota');
<?php
declare(strict_types=1);

namespace App\Core;

abstract class Controller
{
    protected function view(string $template, array $data = [], string $layout = 'main'): void
    {
        extract($data, EXTR_SKIP);
        $viewFile   = __DIR__ . '/../Views/' . $template . '.php';
        $layoutFile = __DIR__ . '/../Views/layouts/' . $layout . '.php';

        ob_start();
        if (is_file($viewFile)) {
            require $viewFile;
        } else {
            echo "<div style='padding:20px;background:#fee;color:#900'>Vista no encontrada: {$template}</div>";
        }
        $content = ob_get_clean();

        if (is_file($layoutFile)) {
            require $layoutFile;
        } else {
            echo $content;
        }
    }

    protected function redirect(string $path): void
    {
        $base = getenv('APP_URL') ?: '';
        header('Location: ' . $base . '/' . ltrim($path, '/'));
        exit;
    }

    protected function input(): array
    {
        $ct = $_SERVER['CONTENT_TYPE'] ?? '';
        if (str_contains($ct, 'application/json')) {
            $raw = file_get_contents('php://input');
            return json_decode($raw, true) ?: [];
        }
        return $_POST ?: [];
    }
}
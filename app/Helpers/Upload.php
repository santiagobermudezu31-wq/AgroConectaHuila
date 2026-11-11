<?php
declare(strict_types=1);

namespace App\Helpers;

class Upload
{
    public static function save(array $file, string $destDir): string
    {
        $cfg = require __DIR__ . '/../../config/app.php';

        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            throw new \RuntimeException('Error al subir el archivo.');
        }

        $max = $cfg['upload_max_mb'] * 1024 * 1024;
        if ($file['size'] > $max) {
            throw new \RuntimeException('El archivo excede el tamaño permitido.');
        }

        $mime = mime_content_type($file['tmp_name']);
        if (!in_array($mime, $cfg['upload_types'], true)) {
            throw new \RuntimeException('Formato no permitido.');
        }

        $ext = match ($mime) {
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            'image/webp' => 'webp',
            default      => 'jpg',
        };

        $root   = dirname(__DIR__, 2);
        $absDir = $root . '/' . ltrim($destDir, '/');
        if (!is_dir($absDir)) mkdir($absDir, 0755, true);

        $name   = bin2hex(random_bytes(16)) . '.' . $ext;
        $target = $absDir . '/' . $name;

        if (!move_uploaded_file($file['tmp_name'], $target)) {
            throw new \RuntimeException('No se pudo guardar la imagen.');
        }

        return ltrim($destDir, '/') . '/' . $name;
    }
}
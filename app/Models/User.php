<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class User extends Model
{
    protected string $table = 'usuarios';

    public function findByLogin(string $ident): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT * FROM usuarios WHERE correo = ? OR nombre_usuario = ? LIMIT 1'
        );
        $stmt->execute([$ident, $ident]);
        return $stmt->fetch() ?: null;
    }

    public function create(array $d): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO usuarios (nombre_usuario, correo, password_hash, rol, estado)
             VALUES (?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $d['nombre_usuario'],
            $d['correo'],
            password_hash($d['password'], PASSWORD_DEFAULT),
            $d['rol'] ?? 'productor',
            $d['estado'] ?? 'activo',
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function exists(string $usuario, string $correo): bool
    {
        $stmt = $this->db->prepare(
            'SELECT id FROM usuarios WHERE correo = ? OR nombre_usuario = ? LIMIT 1'
        );
        $stmt->execute([$correo, $usuario]);
        return (bool)$stmt->fetch();
    }
}
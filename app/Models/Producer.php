<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class Producer extends Model
{
    protected string $table = 'productores';

    public function create(array $d): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO productores
             (usuario_id, nombre_productor, nombre_unidad_productiva, zona_vereda,
              municipio, departamento, telefono_comercial, mostrar_telefono)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $d['usuario_id'],
            $d['nombre_productor'],
            $d['nombre_unidad_productiva'] ?? null,
            $d['zona_vereda'],
            $d['municipio'],
            $d['departamento'],
            $d['telefono_comercial'] ?? null,
            (int)($d['mostrar_telefono'] ?? 0),
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function byUserId(int $uid): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM productores WHERE usuario_id = ? LIMIT 1');
        $stmt->execute([$uid]);
        return $stmt->fetch() ?: null;
    }

    public function update(int $id, array $d): void
    {
        $stmt = $this->db->prepare(
            'UPDATE productores SET
                nombre_productor=?, nombre_unidad_productiva=?, zona_vereda=?,
                municipio=?, departamento=?, telefono_comercial=?, mostrar_telefono=?
             WHERE id=?'
        );
        $stmt->execute([
            $d['nombre_productor'],
            $d['nombre_unidad_productiva'] ?? null,
            $d['zona_vereda'],
            $d['municipio'],
            $d['departamento'],
            $d['telefono_comercial'] ?? null,
            (int)($d['mostrar_telefono'] ?? 0),
            $id,
        ]);
    }

    public function dashboardStats(int $producerId): array
    {
        $stmt = $this->db->prepare(
            "SELECT
                COUNT(*) AS total,
                SUM(estado_publicacion='activo') AS activas,
                SUM(estado_publicacion='pendiente') AS pendientes,
                SUM(estado_publicacion='retirado') AS retiradas,
                SUM(disponibilidad='agotado' AND estado_publicacion='activo') AS agotados
             FROM productos WHERE productor_id = ?"
        );
        $stmt->execute([$producerId]);
        return $stmt->fetch() ?: [];
    }
}
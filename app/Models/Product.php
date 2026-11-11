<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class Product extends Model
{
    protected string $table = 'productos';

    public function create(array $d): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO productos
             (productor_id, categoria_id, nombre, descripcion, tipo_producto,
              unidad_comercializacion, precio, disponibilidad, estado_publicacion)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $d['productor_id'], $d['categoria_id'], $d['nombre'], $d['descripcion'],
            $d['tipo_producto'], $d['unidad_comercializacion'], $d['precio'],
            $d['disponibilidad'], $d['estado_publicacion'] ?? 'pendiente',
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, array $d): void
    {
        $stmt = $this->db->prepare(
            'UPDATE productos SET
                categoria_id=?, nombre=?, descripcion=?, tipo_producto=?,
                unidad_comercializacion=?, precio=?, disponibilidad=?, estado_publicacion=?
             WHERE id=?'
        );
        $stmt->execute([
            $d['categoria_id'], $d['nombre'], $d['descripcion'], $d['tipo_producto'],
            $d['unidad_comercializacion'], $d['precio'], $d['disponibilidad'],
            $d['estado_publicacion'] ?? 'pendiente', $id,
        ]);
    }

    public function byProducer(int $pid): array
    {
        $stmt = $this->db->prepare(
            'SELECT pr.*, c.nombre AS categoria,
                (SELECT url_imagen FROM imagenes_productos
                 WHERE producto_id=pr.id ORDER BY es_principal DESC, orden ASC LIMIT 1) AS imagen
             FROM productos pr INNER JOIN categorias c ON c.id = pr.categoria_id
             WHERE pr.productor_id = ?
             ORDER BY pr.fecha_creacion DESC'
        );
        $stmt->execute([$pid]);
        return $stmt->fetchAll();
    }

    public function belongsTo(int $productId, int $producerId): bool
    {
        $stmt = $this->db->prepare(
            'SELECT id FROM productos WHERE id=? AND productor_id=? LIMIT 1'
        );
        $stmt->execute([$productId, $producerId]);
        return (bool)$stmt->fetch();
    }

    public function related(int $productId, int $catId, int $limit = 4): array
    {
        $stmt = $this->db->prepare(
            "SELECT pr.*, c.nombre AS categoria,
                (SELECT url_imagen FROM imagenes_productos
                 WHERE producto_id=pr.id ORDER BY es_principal DESC, orden ASC LIMIT 1) AS imagen
             FROM productos pr INNER JOIN categorias c ON c.id = pr.categoria_id
             WHERE pr.categoria_id = ? AND pr.id <> ? AND pr.estado_publicacion='activo'
             ORDER BY RAND() LIMIT {$limit}"
        );
        $stmt->execute([$catId, $productId]);
        return $stmt->fetchAll();
    }
}
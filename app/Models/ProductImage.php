<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class ProductImage extends Model
{
    protected string $table = 'imagenes_productos';

    public function add(int $productId, string $url, bool $principal, int $order = 0): void
    {
        $stmt = $this->db->prepare(
            'INSERT INTO imagenes_productos (producto_id, url_imagen, es_principal, orden)
             VALUES (?, ?, ?, ?)'
        );
        $stmt->execute([$productId, $url, (int)$principal, $order]);
    }

    public function forProduct(int $pid): array
    {
        $stmt = $this->db->prepare(
            'SELECT * FROM imagenes_productos WHERE producto_id = ?
             ORDER BY es_principal DESC, orden ASC'
        );
        $stmt->execute([$pid]);
        return $stmt->fetchAll();
    }
}
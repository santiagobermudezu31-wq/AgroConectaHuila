<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class Category extends Model
{
    protected string $table = 'categorias';

    public function activas(): array
    {
        return $this->db->query(
            "SELECT * FROM categorias WHERE estado='activa' ORDER BY nombre"
        )->fetchAll();
    }

    public function hasProducts(int $id): bool
    {
        $stmt = $this->db->prepare('SELECT id FROM productos WHERE categoria_id=? LIMIT 1');
        $stmt->execute([$id]);
        return (bool)$stmt->fetch();
    }
}
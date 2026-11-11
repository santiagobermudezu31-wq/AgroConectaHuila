<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Helpers\Response;

class ProductController
{
    public function index(): void
    {
        $pdo = \Database::connection();
        $page = max(1, (int)($_GET['page'] ?? 1));
        $per  = 12;
        $offset = ($page - 1) * $per;

        $total = (int)$pdo->query(
            "SELECT COUNT(*) FROM productos WHERE estado_publicacion='activo'"
        )->fetchColumn();

        $items = $pdo->query(
            "SELECT pr.*, c.nombre AS categoria, p.nombre_productor, p.municipio
             FROM productos pr
             INNER JOIN categorias c ON c.id = pr.categoria_id
             INNER JOIN productores p ON p.id = pr.productor_id
             WHERE pr.estado_publicacion='activo'
             ORDER BY pr.fecha_creacion DESC
             LIMIT {$per} OFFSET {$offset}"
        )->fetchAll();

        Response::success('OK', [
            'items' => $items,
            'pagination' => [
                'page'        => $page,
                'per_page'    => $per,
                'total'       => $total,
                'total_pages' => (int)ceil($total / $per),
            ],
        ]);
    }

    public function show(string $id): void
    {
        $stmt = \Database::connection()->prepare(
            "SELECT * FROM productos WHERE id=? AND estado_publicacion='activo' LIMIT 1"
        );
        $stmt->execute([(int)$id]);
        $p = $stmt->fetch();
        if (!$p) Response::error('No encontrado', 404);
        Response::success('OK', $p);
    }
}
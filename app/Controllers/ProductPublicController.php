<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Product;
use App\Models\ProductImage;

class ProductPublicController extends Controller
{
    public function show(string $id): void
    {
        $pdo = \Database::connection();
        $stmt = $pdo->prepare(
            "SELECT pr.*, c.nombre AS categoria,
                    p.id AS producer_id, p.nombre_productor, p.nombre_unidad_productiva,
                    p.zona_vereda, p.municipio, p.departamento,
                    p.telefono_comercial, p.mostrar_telefono
             FROM productos pr
             INNER JOIN productores p ON p.id = pr.productor_id
             INNER JOIN usuarios u ON u.id = p.usuario_id
             INNER JOIN categorias c ON c.id = pr.categoria_id
             WHERE pr.id = ? AND pr.estado_publicacion='activo' AND u.estado='activo' LIMIT 1"
        );
        $stmt->execute([(int)$id]);
        $producto = $stmt->fetch();

        if (!$producto) {
            http_response_code(404);
            echo '<h1>Producto no encontrado</h1>';
            return;
        }

        $imagenes    = (new ProductImage())->forProduct((int)$id);
        $relacionados= (new Product())->related((int)$id, (int)$producto['categoria_id']);

        $this->view('products/show', compact('producto', 'imagenes', 'relacionados'));
    }
}
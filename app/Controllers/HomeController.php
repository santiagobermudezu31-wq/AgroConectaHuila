<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;

class HomeController extends Controller
{
    public function index(): void
    {
        $pdo = \Database::connection();

        $categorias = $pdo->query(
            "SELECT * FROM categorias WHERE estado='activa' ORDER BY id"
        )->fetchAll();

        $destacados = $pdo->query(
            "SELECT pr.*, c.nombre AS categoria, p.nombre_productor, p.municipio,
                (SELECT url_imagen FROM imagenes_productos
                 WHERE producto_id=pr.id ORDER BY es_principal DESC, orden ASC LIMIT 1) AS imagen
             FROM productos pr
             INNER JOIN productores p ON p.id = pr.productor_id
             INNER JOIN usuarios u ON u.id = p.usuario_id
             INNER JOIN categorias c ON c.id = pr.categoria_id
             WHERE pr.estado_publicacion='activo' AND u.estado='activo'
             ORDER BY pr.fecha_creacion DESC LIMIT 6"
        )->fetchAll();

        $this->view('home/index', compact('categorias', 'destacados'));
    }
}
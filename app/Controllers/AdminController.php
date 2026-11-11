<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Helpers\Response;
use App\Models\Category;

class AdminController extends Controller
{
    public function dashboard(): void
    {
        $pdo = \Database::connection();
        $stats = [
            'productores' => (int)$pdo->query("SELECT COUNT(*) FROM usuarios WHERE rol='productor'")->fetchColumn(),
            'productos'   => (int)$pdo->query("SELECT COUNT(*) FROM productos")->fetchColumn(),
            'activos'     => (int)$pdo->query("SELECT COUNT(*) FROM productos WHERE estado_publicacion='activo'")->fetchColumn(),
            'pendientes'  => (int)$pdo->query("SELECT COUNT(*) FROM productos WHERE estado_publicacion='pendiente'")->fetchColumn(),
            'retirados'   => (int)$pdo->query("SELECT COUNT(*) FROM productos WHERE estado_publicacion='retirado'")->fetchColumn(),
            'categorias'  => (int)$pdo->query("SELECT COUNT(*) FROM categorias")->fetchColumn(),
        ];
        $this->view('admin/dashboard', compact('stats'), 'dashboard');
    }

    public function producers(): void
    {
        $rows = \Database::connection()->query(
            "SELECT p.*, u.nombre_usuario, u.correo, u.estado AS estado_usuario
             FROM productores p INNER JOIN usuarios u ON u.id = p.usuario_id
             ORDER BY p.fecha_registro DESC"
        )->fetchAll();
        $this->view('admin/producers', compact('rows'), 'dashboard');
    }

    public function toggleProducer(string $id): void
    {
        \Database::connection()->prepare(
            "UPDATE usuarios SET estado = IF(estado='activo','suspendido','activo')
             WHERE id = (SELECT usuario_id FROM productores WHERE id=?)"
        )->execute([(int)$id]);
        Response::success('Estado actualizado.');
    }

    public function products(): void
    {
        $rows = \Database::connection()->query(
            "SELECT pr.*, c.nombre AS categoria, p.nombre_productor,
                (SELECT url_imagen FROM imagenes_productos
                 WHERE producto_id=pr.id ORDER BY es_principal DESC, orden ASC LIMIT 1) AS imagen
             FROM productos pr
             INNER JOIN categorias c ON c.id = pr.categoria_id
             INNER JOIN productores p ON p.id = pr.productor_id
             ORDER BY pr.fecha_creacion DESC"
        )->fetchAll();
        $this->view('admin/products', compact('rows'), 'dashboard');
    }

    public function approve(string $id): void
    {
        \Database::connection()->prepare(
            "UPDATE productos SET estado_publicacion='activo' WHERE id=?"
        )->execute([(int)$id]);
        Response::success('Producto aprobado.');
    }

    public function reject(string $id): void
    {
        \Database::connection()->prepare(
            "UPDATE productos SET estado_publicacion='rechazado' WHERE id=?"
        )->execute([(int)$id]);
        Response::success('Producto rechazado.');
    }

    public function categories(): void
    {
        $cats = (new Category())->all();
        $this->view('admin/categories', compact('cats'), 'dashboard');
    }
}
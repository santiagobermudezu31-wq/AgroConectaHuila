<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;

class CatalogController extends Controller
{
    public function index(): void
    {
        $pdo = \Database::connection();

        $q        = trim($_GET['q'] ?? '');
        $cat      = trim($_GET['categoria'] ?? '');
        $municipio= trim($_GET['municipio'] ?? '');
        $vereda   = trim($_GET['vereda'] ?? '');
        $disp     = trim($_GET['disponibilidad'] ?? '');
        $pmin     = $_GET['precio_min'] ?? '';
        $pmax     = $_GET['precio_max'] ?? '';
        $orden    = $_GET['orden'] ?? 'recientes';
        $page     = max(1, (int)($_GET['page'] ?? 1));
        $per      = 9;

        $w = ["pr.estado_publicacion='activo'", "u.estado='activo'"];
        $params = [];

        if ($q !== '') {
            $w[]  = '(pr.nombre LIKE ? OR pr.descripcion LIKE ? OR pr.tipo_producto LIKE ? OR c.nombre LIKE ?)';
            $like = "%$q%";
            array_push($params, $like, $like, $like, $like);
        }
        if ($cat !== '')       { $w[] = 'c.nombre = ?';        $params[] = $cat; }
        if ($municipio !== '') { $w[] = 'p.municipio = ?';     $params[] = $municipio; }
        if ($vereda !== '')    { $w[] = 'p.zona_vereda = ?';   $params[] = $vereda; }
        if (in_array($disp, ['en_stock','agotado'], true)) { $w[] = 'pr.disponibilidad = ?'; $params[] = $disp; }
        if ($pmin !== '')      { $w[] = 'pr.precio >= ?';      $params[] = (float)$pmin; }
        if ($pmax !== '')      { $w[] = 'pr.precio <= ?';      $params[] = (float)$pmax; }

        $orderSql = match ($orden) {
            'precio_asc'  => 'pr.precio ASC',
            'precio_desc' => 'pr.precio DESC',
            'alfabetico'  => 'pr.nombre ASC',
            default       => 'pr.fecha_creacion DESC',
        };

        $from  = 'FROM productos pr
                 INNER JOIN productores p ON p.id = pr.productor_id
                 INNER JOIN usuarios u ON u.id = p.usuario_id
                 INNER JOIN categorias c ON c.id = pr.categoria_id';
        $where = 'WHERE ' . implode(' AND ', $w);

        $c = $pdo->prepare("SELECT COUNT(*) $from $where");
        $c->execute($params);
        $total = (int)$c->fetchColumn();
        $pages = max(1, (int)ceil($total / $per));
        $page  = min($page, $pages);
        $offset= ($page - 1) * $per;

        $sql = "SELECT pr.*, c.nombre AS categoria, p.nombre_productor, p.municipio,
                    p.zona_vereda, p.telefono_comercial, p.mostrar_telefono,
                    (SELECT url_imagen FROM imagenes_productos
                     WHERE producto_id=pr.id ORDER BY es_principal DESC, orden ASC LIMIT 1) AS imagen
                $from $where ORDER BY $orderSql LIMIT $per OFFSET $offset";
        $s = $pdo->prepare($sql);
        $s->execute($params);
        $productos = $s->fetchAll();

        $categorias = $pdo->query(
            "SELECT * FROM categorias WHERE estado='activa' ORDER BY nombre"
        )->fetchAll();

        $this->view('catalog/index', compact(
            'productos','categorias','total','page','pages',
            'q','cat','municipio','vereda','disp','pmin','pmax','orden'
        ));
    }
}
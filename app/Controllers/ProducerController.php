<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Helpers\Response;
use App\Helpers\Security;
use App\Helpers\Upload;
use App\Models\Category;
use App\Models\Producer;
use App\Models\Product;
use App\Models\ProductImage;

class ProducerController extends Controller
{
    private function producer(): array
    {
        $p = (new Producer())->byUserId((int)$_SESSION['usuario_id']);
        if (!$p) {
            http_response_code(403);
            die('No es productor');
        }
        return $p;
    }

    public function dashboard(): void
    {
        $prod   = $this->producer();
        $stats  = (new Producer())->dashboardStats((int)$prod['id']);
        $productos = (new Product())->byProducer((int)$prod['id']);
        $recientes = array_slice($productos, 0, 5);
        $this->view('producer/dashboard', compact('prod', 'stats', 'recientes', 'productos'), 'dashboard');
    }

    public function publications(): void
    {
        $prod = $this->producer();
        $productos = (new Product())->byProducer((int)$prod['id']);
        $this->view('producer/publications', compact('prod', 'productos'), 'dashboard');
    }

    public function profileForm(): void
    {
        $prod = $this->producer();
        $this->view('producer/profile', compact('prod'), 'dashboard');
    }

    public function profileSave(): void
    {
        $prod = $this->producer();
        $in   = $this->input();
        (new Producer())->update((int)$prod['id'], [
            'nombre_productor'         => trim($in['nombre_productor'] ?? ''),
            'nombre_unidad_productiva' => trim($in['nombre_unidad_productiva'] ?? ''),
            'zona_vereda'              => trim($in['zona_vereda'] ?? ''),
            'municipio'                => trim($in['municipio'] ?? 'La Plata'),
            'departamento'             => trim($in['departamento'] ?? 'Huila'),
            'telefono_comercial'       => trim($in['telefono_comercial'] ?? ''),
            'mostrar_telefono'         => isset($in['mostrar_telefono']) ? 1 : 0,
        ]);
        $this->redirect('/panel/perfil');
    }

    public function newProduct(): void
    {
        $categorias = (new Category())->activas();
        $cfg = require __DIR__ . '/../../config/app.php';
        $this->view('producer/product_form', [
            'categorias' => $categorias,
            'cfg'        => $cfg,
            'producto'   => null,
        ], 'dashboard');
    }

    public function storeProduct(): void
    {
        $prod = $this->producer();
        $in   = $this->input();

        $pid = (new Product())->create([
            'productor_id' => (int)$prod['id'],
            'categoria_id' => (int)($in['categoria_id'] ?? 0),
            'nombre'       => trim($in['nombre'] ?? ''),
            'descripcion'  => trim($in['descripcion'] ?? ''),
            'tipo_producto'=> trim($in['tipo_producto'] ?? ''),
            'unidad_comercializacion' => trim($in['unidad_comercializacion'] ?? ''),
            'precio'       => ($in['precio'] ?? '') !== '' ? (float)$in['precio'] : null,
            'disponibilidad' => $in['disponibilidad'] ?? 'en_stock',
            'estado_publicacion' => 'pendiente',
        ]);

        if (!empty($_FILES['imagen']['name'])) {
            try {
                $url = Upload::save($_FILES['imagen'], 'storage/uploads/products');
                (new ProductImage())->add($pid, $url, true);
            } catch (\Throwable $e) {
                // ignorar
            }
        }

        \Database::connection()->prepare(
            'INSERT INTO historial_publicaciones (producto_id, usuario_id, accion, descripcion)
             VALUES (?, ?, "crear", "Producto creado")'
        )->execute([$pid, (int)$_SESSION['usuario_id']]);

        $this->redirect('/panel/publicaciones');
    }

    public function editProduct(string $id): void
    {
        $prod = $this->producer();
        $p    = (new Product())->find((int)$id);
        if (!$p || (int)$p['productor_id'] !== (int)$prod['id']) {
            http_response_code(404);
            die('No encontrado');
        }
        $categorias = (new Category())->activas();
        $cfg = require __DIR__ . '/../../config/app.php';
        $this->view('producer/product_form', compact('categorias', 'cfg', 'p') + ['producto' => $p], 'dashboard');
    }

    public function updateProduct(string $id): void
    {
        $prod = $this->producer();
        if (!(new Product())->belongsTo((int)$id, (int)$prod['id'])) {
            http_response_code(403);
            die('Prohibido');
        }
        $in = $this->input();
        (new Product())->update((int)$id, [
            'categoria_id' => (int)($in['categoria_id'] ?? 0),
            'nombre'       => trim($in['nombre'] ?? ''),
            'descripcion'  => trim($in['descripcion'] ?? ''),
            'tipo_producto'=> trim($in['tipo_producto'] ?? ''),
            'unidad_comercializacion' => trim($in['unidad_comercializacion'] ?? ''),
            'precio'       => ($in['precio'] ?? '') !== '' ? (float)$in['precio'] : null,
            'disponibilidad' => $in['disponibilidad'] ?? 'en_stock',
            'estado_publicacion' => 'pendiente',
        ]);
        $this->redirect('/panel/publicaciones');
    }

    public function withdraw(string $id): void
    {
        $prod = $this->producer();
        if (!(new Product())->belongsTo((int)$id, (int)$prod['id'])) {
            http_response_code(403);
            die('Prohibido');
        }
        $pdo = \Database::connection();
        $pdo->prepare("UPDATE productos SET estado_publicacion='retirado' WHERE id=?")
            ->execute([(int)$id]);
        $pdo->prepare(
            'INSERT INTO historial_publicaciones (producto_id,usuario_id,accion,descripcion)
             VALUES (?, ?, "retirar", "Publicación retirada por el productor")'
        )->execute([(int)$id, (int)$_SESSION['usuario_id']]);
        Response::success('Publicación retirada.');
    }
}
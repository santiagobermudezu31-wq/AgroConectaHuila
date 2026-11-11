<?php
use App\Helpers\Security;
$base = getenv('APP_URL') ?: '';
$rol = Security::role();
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Panel — AgroConecta Huila</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<link href="<?= $base ?>/public/assets/css/style.css" rel="stylesheet">
<link href="<?= $base ?>/public/assets/css/dashboard.css" rel="stylesheet">
<link href="<?= $base ?>/public/assets/css/responsive.css" rel="stylesheet">
</head>
<body>
<div class="d-flex">
  <aside class="sidebar p-3 text-white">
    <div class="d-flex align-items-center gap-2 mb-4">
      <img src="<?= $base ?>/public/assets/img/logo.svg" height="32">
      <strong>AgroConecta</strong>
    </div>
    <ul class="nav flex-column">
      <?php if ($rol === 'administrador'): ?>
        <li><a class="nav-link text-white" href="<?= $base ?>/admin"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
        <li><a class="nav-link text-white" href="<?= $base ?>/admin/productores"><i class="bi bi-people"></i> Productores</a></li>
        <li><a class="nav-link text-white" href="<?= $base ?>/admin/productos"><i class="bi bi-box"></i> Productos</a></li>
        <li><a class="nav-link text-white" href="<?= $base ?>/admin/categorias"><i class="bi bi-tags"></i> Categorías</a></li>
      <?php else: ?>
        <li><a class="nav-link text-white" href="<?= $base ?>/panel"><i class="bi bi-house"></i> Inicio</a></li>
        <li><a class="nav-link text-white" href="<?= $base ?>/panel/perfil"><i class="bi bi-person"></i> Mi perfil</a></li>
        <li><a class="nav-link text-white" href="<?= $base ?>/panel/publicaciones"><i class="bi bi-box"></i> Publicaciones</a></li>
        <li><a class="nav-link text-white" href="<?= $base ?>/panel/nueva"><i class="bi bi-plus-circle"></i> Nueva publicación</a></li>
      <?php endif; ?>
      <li>
        <form method="post" action="<?= $base ?>/logout" class="mt-3">
          <button class="btn btn-outline-light btn-sm w-100">
            <i class="bi bi-box-arrow-right"></i> Cerrar sesión
          </button>
        </form>
      </li>
    </ul>
  </aside>
  <main class="flex-grow-1 p-4 bg-light min-vh-100"><?= $content ?></main>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= $base ?>/public/assets/js/dashboard.js"></script>
</body>
</html>
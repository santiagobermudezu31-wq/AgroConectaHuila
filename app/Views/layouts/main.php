<?php
use App\Helpers\Security;
$base = getenv('APP_URL') ?: '';
$title = 'AgroConecta Huila';
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= Security::e($title) ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<link href="<?= $base ?>/public/assets/css/style.css" rel="stylesheet">
<link href="<?= $base ?>/public/assets/css/responsive.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center gap-2" href="<?= $base ?>/">
      <img src="<?= $base ?>/public/assets/img/logo.svg" alt="AgroConecta" height="36">
      <span class="fw-bold text-success">AgroConecta Huila</span>
    </a>
    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="nav">
      <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-3">
        <li class="nav-item"><a class="nav-link" href="<?= $base ?>/">Inicio</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= $base ?>/catalogo">Catálogo</a></li>
        <?php if (Security::isLoggedIn()): ?>
          <?php if (Security::role() === 'administrador'): ?>
            <li class="nav-item"><a class="nav-link" href="<?= $base ?>/admin">Panel admin</a></li>
          <?php else: ?>
            <li class="nav-item"><a class="nav-link" href="<?= $base ?>/panel">Mi panel</a></li>
          <?php endif; ?>
          <li class="nav-item">
            <form method="post" action="<?= $base ?>/logout">
              <button class="btn btn-outline-success btn-sm">Cerrar sesión</button>
            </form>
          </li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="<?= $base ?>/registro">Registrarse</a></li>
          <li class="nav-item"><a class="btn btn-success btn-sm px-3" href="<?= $base ?>/login">Iniciar sesión</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<?= $content ?>

<footer class="bg-dark text-white py-4 mt-5">
  <div class="container text-center">
    <p class="mb-1 fw-bold">AgroConecta Huila</p>
    <p class="small mb-0">Conectamos productos del campo con nuevas oportunidades.</p>
    <p class="small text-white-50 mb-0">© <?= date('Y') ?> AgroConecta Huila. Todos los derechos reservados.</p>
  </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= $base ?>/public/assets/js/main.js"></script>
</body>
</html>
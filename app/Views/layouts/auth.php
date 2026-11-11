<?php use App\Helpers\Security; $base = getenv('APP_URL') ?: ''; ?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Acceso — AgroConecta Huila</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<link href="<?= $base ?>/public/assets/css/style.css" rel="stylesheet">
</head>
<body class="auth-bg">
<div class="container py-5">
  <div class="text-center mb-4">
    <img src="<?= $base ?>/public/assets/img/logo.svg" height="52" alt="AgroConecta">
    <h1 class="h4 text-success mt-2 fw-bold">AgroConecta Huila</h1>
  </div>
  <div class="card shadow-sm mx-auto" style="max-width:480px"><?= $content ?></div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
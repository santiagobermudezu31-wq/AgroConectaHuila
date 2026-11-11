<?php use App\Helpers\Security; $base = getenv('APP_URL') ?: ''; ?>
<section class="hero text-white d-flex align-items-center" style="min-height:70vh">
  <div class="container py-5">
    <h1 class="display-4 fw-bold">Conectamos productos del campo<br>con nuevas oportunidades</h1>
    <p class="lead mt-3">Un espacio digital para conocer y divulgar los productos agrícolas de La Plata, Huila.</p>
    <a href="<?= $base ?>/catalogo" class="btn btn-warning btn-lg mt-3">Explorar catálogo</a>
  </div>
</section>

<section class="container py-5">
  <h2 class="h3 text-success fw-bold mb-4">Nuestras categorías</h2>
  <div class="row g-4">
    <?php foreach ($categorias as $c): ?>
      <div class="col-md-4">
        <div class="card h-100 shadow-sm border-0">
          <div class="card-body">
            <h5 class="card-title text-success"><?= Security::e($c['nombre']) ?></h5>
            <p class="text-muted small"><?= Security::e($c['descripcion']) ?></p>
            <a href="<?= $base ?>/catalogo?categoria=<?= urlencode($c['nombre']) ?>"
               class="btn btn-outline-success btn-sm">Ver productos</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<section class="bg-white py-5">
  <div class="container">
    <h2 class="h3 text-success fw-bold mb-4">Productos destacados</h2>
    <?php if (!$destacados): ?>
      <div class="alert alert-info">Aún no hay productos publicados. ¡Sé el primero en publicar!</div>
    <?php else: ?>
      <div class="row g-4">
        <?php foreach ($destacados as $p): ?>
          <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0">
              <img src="<?= $base ?>/<?= Security::e($p['imagen'] ?? 'public/assets/img/placeholder.jpg') ?>"
                   class="card-img-top" style="height:200px;object-fit:cover">
              <div class="card-body">
                <span class="badge bg-success-subtle text-success"><?= Security::e($p['categoria']) ?></span>
                <h5 class="mt-2"><?= Security::e($p['nombre']) ?></h5>
                <p class="mb-1"><strong>Precio:</strong>
                   <?= $p['precio'] ? '$' . number_format((float)$p['precio'], 0, ',', '.') : 'Consultar' ?></p>
                <p class="mb-1 small text-muted"><?= Security::e($p['municipio']) ?></p>
                <a href="<?= $base ?>/producto/<?= $p['id'] ?>" class="btn btn-success btn-sm w-100 mt-2">Ver detalle</a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>

<section class="container py-5">
  <h2 class="h3 text-success fw-bold">¿Qué es AgroConecta Huila?</h2>
  <p>Plataforma digital que conecta a pequeños y medianos productores de La Plata, Huila con compradores de todo el país. Promovemos la comercialización directa, fortalecemos la presencia digital del campo y creamos nuevas oportunidades para el desarrollo rural.</p>
</section>
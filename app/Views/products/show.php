<?php use App\Helpers\Security; $base = getenv('APP_URL') ?: ''; ?>
<div class="container py-4">
  <a href="<?= $base ?>/catalogo" class="btn btn-sm btn-outline-secondary mb-3">← Volver al catálogo</a>

  <div class="row g-4">
    <div class="col-md-6">
      <?php $main = $imagenes[0]['url_imagen'] ?? 'public/assets/img/placeholder.jpg'; ?>
      <img src="<?= $base ?>/<?= Security::e($main) ?>" class="img-fluid rounded shadow-sm w-100"
           style="object-fit:cover;max-height:420px">
      <div class="d-flex gap-2 mt-2 flex-wrap">
        <?php foreach ($imagenes as $img): ?>
          <img src="<?= $base ?>/<?= Security::e($img['url_imagen']) ?>"
               class="rounded border" style="height:70px;width:70px;object-fit:cover">
        <?php endforeach; ?>
      </div>
    </div>
    <div class="col-md-6">
      <span class="badge bg-success-subtle text-success mb-2"><?= Security::e($producto['categoria']) ?></span>
      <h1 class="h3"><?= Security::e($producto['nombre']) ?></h1>
      <p class="text-muted"><?= nl2br(Security::e($producto['descripcion'])) ?></p>
      <ul class="list-unstyled small">
        <li><strong>Tipo:</strong> <?= Security::e($producto['tipo_producto']) ?></li>
        <li><strong>Unidad:</strong> <?= Security::e($producto['unidad_comercializacion']) ?></li>
        <li><strong>Precio:</strong> <?= $producto['precio'] ? '$' . number_format((float)$producto['precio'], 0, ',', '.') : 'A convenir' ?></li>
        <li><strong>Disponibilidad:</strong> <?= $producto['disponibilidad'] === 'en_stock' ? 'En stock' : 'Agotado' ?></li>
      </ul>

      <div class="card bg-light mt-3">
        <div class="card-body small">
          <strong><?= Security::e($producto['nombre_productor']) ?></strong><br>
          <?= Security::e($producto['nombre_unidad_productiva']) ?><br>
          <?= Security::e($producto['zona_vereda']) ?>, <?= Security::e($producto['municipio']) ?>
        </div>
      </div>

      <?php
      $tel = preg_replace('/[^0-9]/', '', $producto['telefono_comercial'] ?? '');
      $msg = rawurlencode("Hola, estoy interesado en el producto {$producto['nombre']} publicado en AgroConecta Huila. ¿Podría brindarme más información?");
      ?>
      <div class="d-flex gap-2 mt-3">
        <?php if ($tel): ?>
          <a href="https://wa.me/57<?= $tel ?>?text=<?= $msg ?>" target="_blank" class="btn btn-success">
            <i class="bi bi-whatsapp"></i> WhatsApp
          </a>
          <?php if ((int)$producto['mostrar_telefono'] === 1): ?>
            <a href="tel:<?= $tel ?>" class="btn btn-outline-success">
              <i class="bi bi-telephone"></i> Llamar
            </a>
          <?php endif; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <?php if ($relacionados): ?>
    <h2 class="h5 text-success fw-bold mt-5">Productos relacionados</h2>
    <div class="row g-3">
      <?php foreach ($relacionados as $r): ?>
        <div class="col-md-3">
          <a href="<?= $base ?>/producto/<?= $r['id'] ?>" class="text-decoration-none">
            <div class="card h-100 shadow-sm border-0">
              <img src="<?= $base ?>/<?= Security::e($r['imagen'] ?? 'public/assets/img/placeholder.jpg') ?>"
                   class="card-img-top" style="height:140px;object-fit:cover">
              <div class="card-body p-2">
                <strong class="text-success"><?= Security::e($r['nombre']) ?></strong>
              </div>
            </div>
          </a>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>
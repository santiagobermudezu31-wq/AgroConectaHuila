<?php use App\Helpers\Security; $base = getenv('APP_URL') ?: ''; ?>
<div class="container py-4">
  <h1 class="h3 text-success fw-bold">Catálogo de productos</h1>
  <p class="text-muted">Conoce la oferta agrícola de La Plata, Huila.</p>

  <form class="row g-2 mb-3" method="get" id="filters">
    <div class="col-md-6">
      <input name="q" class="form-control" placeholder="Buscar por nombre, tipo o categoría..."
             value="<?= Security::e($q) ?>">
    </div>
    <div class="col-md-3">
      <select name="categoria" class="form-select">
        <option value="">Todas las categorías</option>
        <?php foreach ($categorias as $c): ?>
          <option value="<?= Security::e($c['nombre']) ?>" <?= $cat === $c['nombre'] ? 'selected' : '' ?>>
            <?= Security::e($c['nombre']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-3"><button class="btn btn-success w-100">Buscar</button></div>

    <div class="col-md-3">
      <select name="orden" class="form-select">
        <option value="recientes" <?= $orden === 'recientes' ? 'selected' : '' ?>>Más recientes</option>
        <option value="precio_asc" <?= $orden === 'precio_asc' ? 'selected' : '' ?>>Menor precio</option>
        <option value="precio_desc" <?= $orden === 'precio_desc' ? 'selected' : '' ?>>Mayor precio</option>
        <option value="alfabetico" <?= $orden === 'alfabetico' ? 'selected' : '' ?>>Alfabético</option>
      </select>
    </div>
    <div class="col-md-2"><input name="precio_min" type="number" class="form-control" placeholder="Precio mín" value="<?= Security::e((string)$pmin) ?>"></div>
    <div class="col-md-2"><input name="precio_max" type="number" class="form-control" placeholder="Precio máx" value="<?= Security::e((string)$pmax) ?>"></div>
    <div class="col-md-2">
      <select name="disponibilidad" class="form-select">
        <option value="">Disponibilidad</option>
        <option value="en_stock" <?= $disp === 'en_stock' ? 'selected' : '' ?>>En stock</option>
        <option value="agotado" <?= $disp === 'agotado' ? 'selected' : '' ?>>Agotado</option>
      </select>
    </div>
  </form>

  <?php if (!$productos): ?>
    <div class="alert alert-info">
      No se encontraron productos con estos criterios.
      <a href="<?= $base ?>/catalogo">Limpiar filtros</a>
    </div>
  <?php else: ?>
    <div class="row g-4">
      <?php foreach ($productos as $p): ?>
        <div class="col-md-4">
          <div class="card h-100 shadow-sm border-0">
            <img src="<?= $base ?>/<?= Security::e($p['imagen'] ?? 'public/assets/img/placeholder.jpg') ?>"
                 class="card-img-top" style="height:200px;object-fit:cover">
            <div class="card-body">
              <span class="badge bg-success-subtle text-success"><?= Security::e($p['categoria']) ?></span>
              <h5 class="mt-2"><?= Security::e($p['nombre']) ?></h5>
              <p class="small text-muted mb-1"><?= Security::e($p['municipio']) ?> — <?= Security::e($p['zona_vereda']) ?></p>
              <p class="mb-1">
                <strong><?= $p['precio'] ? '$' . number_format((float)$p['precio'], 0, ',', '.') : 'Consultar precio' ?></strong>
                / <?= Security::e($p['unidad_comercializacion']) ?>
              </p>
              <p class="small <?= $p['disponibilidad'] === 'en_stock' ? 'text-success' : 'text-danger' ?>">
                <?= $p['disponibilidad'] === 'en_stock' ? 'En stock' : 'Agotado' ?>
              </p>
              <a class="btn btn-success btn-sm w-100" href="<?= $base ?>/producto/<?= $p['id'] ?>">Ver detalle</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <nav class="mt-4">
      <ul class="pagination justify-content-center">
        <?php for ($i = 1; $i <= $pages; $i++): ?>
          <li class="page-item <?= $i == $page ? 'active' : '' ?>">
            <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>"><?= $i ?></a>
          </li>
        <?php endfor; ?>
      </ul>
    </nav>
  <?php endif; ?>
</div>
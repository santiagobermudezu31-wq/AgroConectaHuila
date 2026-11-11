<?php use App\Helpers\Security; $base = getenv('APP_URL') ?: ''; ?>
<h1 class="h3 text-success fw-bold">Hola, <?= Security::e($prod['nombre_productor']) ?></h1>
<div class="row g-3 mt-2">
  <?php foreach ([
    'Total publicaciones' => $stats['total'] ?? 0,
    'Activas'             => $stats['activas'] ?? 0,
    'Pendientes'          => $stats['pendientes'] ?? 0,
    'Agotados'            => $stats['agotados'] ?? 0,
    'Retiradas'           => $stats['retiradas'] ?? 0,
  ] as $label => $v): ?>
    <div class="col-6 col-md-4 col-lg-2">
      <div class="card border-0 shadow-sm text-center">
        <div class="card-body">
          <div class="h4 text-success"><?= (int)$v ?></div>
          <div class="small text-muted"><?= $label ?></div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<h2 class="h5 text-success fw-bold mt-4">Publicaciones recientes</h2>
<div class="table-responsive bg-white rounded shadow-sm">
  <table class="table mb-0 align-middle">
    <thead><tr><th>Producto</th><th>Categoría</th><th>Estado</th><th></th></tr></thead>
    <tbody>
      <?php foreach ($recientes as $p): ?>
        <tr>
          <td><?= Security::e($p['nombre']) ?></td>
          <td><?= Security::e($p['categoria']) ?></td>
          <td><span class="badge bg-success-subtle text-success"><?= Security::e($p['estado_publicacion']) ?></span></td>
          <td><a class="btn btn-sm btn-outline-success" href="<?= $base ?>/panel/editar/<?= $p['id'] ?>">Editar</a></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
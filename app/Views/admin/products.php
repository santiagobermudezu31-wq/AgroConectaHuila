<?php use App\Helpers\Security; $base = getenv('APP_URL') ?: ''; ?>
<h1 class="h3 text-success fw-bold mb-3">Productos</h1>
<div class="table-responsive bg-white rounded shadow-sm">
  <table class="table align-middle">
    <thead><tr><th>Producto</th><th>Productor</th><th>Categoría</th><th>Estado</th><th></th></tr></thead>
    <tbody>
      <?php foreach ($rows as $r): ?>
        <tr>
          <td><?= Security::e($r['nombre']) ?></td>
          <td><?= Security::e($r['nombre_productor']) ?></td>
          <td><?= Security::e($r['categoria']) ?></td>
          <td><span class="badge bg-success-subtle text-success"><?= Security::e($r['estado_publicacion']) ?></span></td>
          <td class="d-flex gap-1">
            <?php if ($r['estado_publicacion'] !== 'activo'): ?>
              <form method="post" action="<?= $base ?>/admin/productos/<?= $r['id'] ?>/aprobar">
                <button class="btn btn-sm btn-outline-success">Aprobar</button>
              </form>
            <?php endif; ?>
            <?php if ($r['estado_publicacion'] !== 'rechazado'): ?>
              <form method="post" action="<?= $base ?>/admin/productos/<?= $r['id'] ?>/rechazar">
                <button class="btn btn-sm btn-outline-danger">Rechazar</button>
              </form>
            <?php endif; ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
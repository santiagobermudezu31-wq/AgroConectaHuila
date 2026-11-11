<?php use App\Helpers\Security; $base = getenv('APP_URL') ?: ''; ?>
<h1 class="h3 text-success fw-bold mb-3">Productores</h1>
<div class="table-responsive bg-white rounded shadow-sm">
  <table class="table align-middle">
    <thead><tr><th>Productor</th><th>Correo</th><th>Municipio</th><th>Estado</th><th></th></tr></thead>
    <tbody>
      <?php foreach ($rows as $r): ?>
        <tr>
          <td><?= Security::e($r['nombre_productor']) ?></td>
          <td><?= Security::e($r['correo']) ?></td>
          <td><?= Security::e($r['municipio']) ?></td>
          <td>
            <span class="badge bg-<?= $r['estado_usuario'] === 'activo' ? 'success' : 'danger' ?>-subtle">
              <?= Security::e($r['estado_usuario']) ?>
            </span>
          </td>
          <td>
            <form method="post" action="<?= $base ?>/admin/productores/<?= $r['id'] ?>/toggle">
              <button class="btn btn-sm btn-outline-<?= $r['estado_usuario'] === 'activo' ? 'danger' : 'success' ?>">
                <?= $r['estado_usuario'] === 'activo' ? 'Suspender' : 'Activar' ?>
              </button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
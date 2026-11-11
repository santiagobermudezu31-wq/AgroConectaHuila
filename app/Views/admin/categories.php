<?php use App\Helpers\Security; $base = getenv('APP_URL') ?: ''; ?>
<h1 class="h3 text-success fw-bold mb-3">Categorías</h1>
<div class="card border-0 shadow-sm">
  <div class="card-body">
    <table class="table">
      <thead><tr><th>Nombre</th><th>Estado</th><th></th></tr></thead>
      <tbody>
        <?php foreach ($cats as $c): ?>
          <tr>
            <td><?= Security::e($c['nombre']) ?></td>
            <td><?= Security::e($c['estado']) ?></td>
            <td>
              <a class="btn btn-sm btn-outline-success"
                 href="<?= $base ?>/catalogo?categoria=<?= urlencode($c['nombre']) ?>">Ver productos</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
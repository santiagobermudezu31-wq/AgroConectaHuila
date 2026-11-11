<?php use App\Helpers\Security; $base = getenv('APP_URL') ?: ''; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h1 class="h3 text-success fw-bold">Mis publicaciones</h1>
  <a href="<?= $base ?>/panel/nueva" class="btn btn-success">+ Nueva publicación</a>
</div>

<div class="table-responsive bg-white rounded shadow-sm">
  <table class="table align-middle">
    <thead>
      <tr>
        <th>Producto</th><th>Categoría</th><th>Precio</th>
        <th>Disponibilidad</th><th>Estado</th><th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($productos as $p): ?>
        <tr>
          <td><?= Security::e($p['nombre']) ?></td>
          <td><?= Security::e($p['categoria']) ?></td>
          <td><?= $p['precio'] ? '$' . number_format((float)$p['precio'], 0, ',', '.') : '—' ?></td>
          <td><?= $p['disponibilidad'] === 'en_stock' ? 'En stock' : 'Agotado' ?></td>
          <td><span class="badge bg-success-subtle text-success"><?= Security::e($p['estado_publicacion']) ?></span></td>
          <td class="d-flex gap-1">
            <a class="btn btn-sm btn-outline-secondary" href="<?= $base ?>/producto/<?= $p['id'] ?>">Ver</a>
            <a class="btn btn-sm btn-outline-success" href="<?= $base ?>/panel/editar/<?= $p['id'] ?>">Editar</a>
            <button class="btn btn-sm btn-outline-danger" onclick="retirar(<?= $p['id'] ?>)">Retirar</button>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<div class="modal fade" id="modalRetiro">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">¿Retirar publicación?</h5></div>
      <div class="modal-body">El producto dejará de mostrarse en el catálogo público.</div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button class="btn btn-danger" id="confirmRetiro">Confirmar retiro</button>
      </div>
    </div>
  </div>
</div>

<script>
let pendingId = null;
function retirar(id) {
  pendingId = id;
  new bootstrap.Modal(document.getElementById('modalRetiro')).show();
}
document.getElementById('confirmRetiro').addEventListener('click', async () => {
  const r = await fetch(`<?= $base ?>/panel/retirar/${pendingId}`, {method: 'POST'});
  const j = await r.json();
  if (j.success) location.reload(); else alert(j.message);
});
</script>
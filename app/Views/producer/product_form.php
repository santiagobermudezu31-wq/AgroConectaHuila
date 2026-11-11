<?php
use App\Helpers\Security;
$base = getenv('APP_URL') ?: '';
$edit = $producto !== null;
$action = $edit ? $base . '/panel/editar/' . $producto['id'] : $base . '/panel/nueva';
?>
<h1 class="h3 text-success fw-bold mb-3"><?= $edit ? 'Editar' : 'Publicar' ?> producto</h1>
<form method="post" action="<?= $action ?>" enctype="multipart/form-data" class="bg-white p-4 rounded shadow-sm">
  <div class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Nombre *</label>
      <input name="nombre" class="form-control" value="<?= Security::e((string)($producto['nombre'] ?? '')) ?>" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Categoría *</label>
      <select name="categoria_id" class="form-select" required>
        <?php foreach ($categorias as $c): ?>
          <option value="<?= $c['id'] ?>" <?= (int)($producto['categoria_id'] ?? 0) === (int)$c['id'] ? 'selected' : '' ?>>
            <?= Security::e($c['nombre']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-12">
      <label class="form-label">Descripción *</label>
      <textarea name="descripcion" class="form-control" rows="3" required><?= Security::e((string)($producto['descripcion'] ?? '')) ?></textarea>
    </div>
    <div class="col-md-6">
      <label class="form-label">Tipo de producto *</label>
      <select name="tipo_producto" class="form-select" required>
        <?php foreach ($cfg['tipos_producto'] as $t): ?>
          <option <?= ($producto['tipo_producto'] ?? '') === $t ? 'selected' : '' ?>><?= $t ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-6">
      <label class="form-label">Unidad *</label>
      <select name="unidad_comercializacion" class="form-select" required>
        <?php foreach ($cfg['unidades'] as $u): ?>
          <option <?= ($producto['unidad_comercializacion'] ?? '') === $u ? 'selected' : '' ?>><?= $u ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-4">
      <label class="form-label">Precio (COP)</label>
      <input type="number" step="0.01" min="0" name="precio" class="form-control"
             value="<?= Security::e((string)($producto['precio'] ?? '')) ?>">
    </div>
    <div class="col-md-4">
      <label class="form-label">Disponibilidad</label>
      <select name="disponibilidad" class="form-select">
        <option value="en_stock" <?= ($producto['disponibilidad'] ?? 'en_stock') === 'en_stock' ? 'selected' : '' ?>>En stock</option>
        <option value="agotado"  <?= ($producto['disponibilidad'] ?? '') === 'agotado' ? 'selected' : '' ?>>Agotado</option>
      </select>
    </div>
    <div class="col-md-4">
      <label class="form-label">Fotografía</label>
      <input type="file" name="imagen" accept="image/*" class="form-control">
    </div>
  </div>
  <div class="mt-3">
    <button class="btn btn-success"><?= $edit ? 'Guardar cambios' : 'Guardar publicación' ?></button>
    <a href="<?= $base ?>/panel/publicaciones" class="btn btn-outline-secondary">Cancelar</a>
  </div>
</form>
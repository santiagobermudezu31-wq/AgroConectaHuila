<?php use App\Helpers\Security; $base = getenv('APP_URL') ?: ''; ?>
<h1 class="h3 text-success fw-bold mb-3">Mi perfil</h1>
<form method="post" action="<?= $base ?>/panel/perfil" class="bg-white p-4 rounded shadow-sm">
  <div class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Nombre del productor</label>
      <input name="nombre_productor" class="form-control" value="<?= Security::e($prod['nombre_productor']) ?>" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Unidad productiva</label>
      <input name="nombre_unidad_productiva" class="form-control" value="<?= Security::e((string)$prod['nombre_unidad_productiva']) ?>">
    </div>
    <div class="col-md-6">
      <label class="form-label">Zona / vereda</label>
      <input name="zona_vereda" class="form-control" value="<?= Security::e($prod['zona_vereda']) ?>" required>
    </div>
    <div class="col-md-3">
      <label class="form-label">Municipio</label>
      <input name="municipio" class="form-control" value="<?= Security::e($prod['municipio']) ?>">
    </div>
    <div class="col-md-3">
      <label class="form-label">Departamento</label>
      <input name="departamento" class="form-control" value="<?= Security::e($prod['departamento']) ?>">
    </div>
    <div class="col-md-6">
      <label class="form-label">Teléfono comercial</label>
      <input name="telefono_comercial" class="form-control" value="<?= Security::e((string)$prod['telefono_comercial']) ?>">
    </div>
    <div class="col-12">
      <div class="form-check form-switch">
        <input type="checkbox" name="mostrar_telefono" class="form-check-input" id="mt" <?= (int)$prod['mostrar_telefono'] === 1 ? 'checked' : '' ?>>
        <label class="form-check-label" for="mt">Mostrar mi número de contacto en el catálogo público</label>
      </div>
    </div>
  </div>
  <div class="mt-3">
    <button class="btn btn-success">Guardar cambios</button>
    <a href="<?= $base ?>/panel" class="btn btn-outline-secondary">Cancelar</a>
  </div>
</form>
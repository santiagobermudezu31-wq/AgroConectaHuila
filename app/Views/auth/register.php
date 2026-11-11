<?php use App\Helpers\Security; $base = getenv('APP_URL') ?: ''; ?>
<div class="card-body p-4">
  <h2 class="h5 text-success fw-bold mb-3">Registro de productor</h2>
  <form id="registerForm">
    <div class="mb-2"><label class="form-label">Nombre del productor *</label><input name="nombre_productor" class="form-control" required></div>
    <div class="mb-2"><label class="form-label">Nombre de la unidad productiva</label><input name="nombre_unidad_productiva" class="form-control"></div>
    <div class="mb-2"><label class="form-label">Nombre de usuario *</label><input name="nombre_usuario" class="form-control" required></div>
    <div class="mb-2"><label class="form-label">Correo electrónico *</label><input type="email" name="correo" class="form-control" required></div>
    <div class="mb-2"><label class="form-label">Contraseña *</label><input type="password" name="password" class="form-control" minlength="8" required></div>
    <div class="mb-2"><label class="form-label">Confirmar contraseña *</label><input type="password" name="password_confirmacion" class="form-control" required></div>
    <div class="mb-2"><label class="form-label">Zona / vereda *</label><input name="zona_vereda" class="form-control" required></div>
    <div class="row">
      <div class="col mb-2"><label class="form-label">Municipio</label><input name="municipio" class="form-control" value="La Plata"></div>
      <div class="col mb-2"><label class="form-label">Departamento</label><input name="departamento" class="form-control" value="Huila"></div>
    </div>
    <div class="mb-2"><label class="form-label">Medio de contacto comercial</label><input name="telefono_comercial" class="form-control" placeholder="Ej: 3201234567"></div>
    <div class="form-check mb-3">
      <input type="checkbox" class="form-check-input" name="acepta_politica" id="pol" required>
      <label class="form-check-label small" for="pol">Autorizo el tratamiento de datos personales.</label>
    </div>
    <button class="btn btn-success w-100">Crear cuenta</button>
  </form>
  <div class="text-center mt-3 small">
    ¿Ya tienes cuenta? <a href="<?= $base ?>/login">Inicia sesión</a>
  </div>
</div>
<script>
document.getElementById('registerForm').addEventListener('submit', async e => {
  e.preventDefault();
  const fd = new FormData(e.target);
  const body = Object.fromEntries(fd.entries());
  body.acepta_politica = fd.get('acepta_politica') === 'on';
  const r = await fetch('<?= $base ?>/api/auth/register', {
    method: 'POST',
    headers: {'Content-Type': 'application/json'},
    body: JSON.stringify(body)
  });
  const j = await r.json();
  if (j.success) { alert('Registro exitoso'); location.href = '<?= $base ?>/login'; }
  else alert('Error: ' + (j.message || 'Verifique los datos'));
});
</script>
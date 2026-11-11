<?php use App\Helpers\Security; $base = getenv('APP_URL') ?: ''; ?>
<div class="card-body p-4">
  <h2 class="h5 text-success fw-bold mb-3">Iniciar sesión</h2>
  <form id="loginForm">
    <div class="mb-3">
      <label class="form-label">Usuario o correo</label>
      <input name="identificador" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Contraseña</label>
      <div class="input-group">
        <input type="password" id="pass" name="password" class="form-control" required>
        <button type="button" class="btn btn-outline-secondary"
                onclick="document.getElementById('pass').type = document.getElementById('pass').type === 'password' ? 'text' : 'password'">
          <i class="bi bi-eye"></i>
        </button>
      </div>
    </div>
    <button class="btn btn-success w-100">Iniciar sesión</button>
  </form>
  <div class="text-center mt-3 small">
    ¿No tienes cuenta? <a href="<?= $base ?>/registro">Registrarse</a>
  </div>
</div>
<script>
document.getElementById('loginForm').addEventListener('submit', async e => {
  e.preventDefault();
  const fd = new FormData(e.target);
  const r = await fetch('<?= $base ?>/api/auth/login', {
    method: 'POST',
    headers: {'Content-Type': 'application/json'},
    body: JSON.stringify(Object.fromEntries(fd))
  });
  const j = await r.json();
  if (j.success) {
    location.href = j.data.usuario.rol === 'administrador' ? '<?= $base ?>/admin' : '<?= $base ?>/panel';
  } else alert(j.message);
});
</script>
<h1 class="h3 text-success fw-bold">Panel administrativo</h1>
<div class="row g-3 mt-2">
  <?php foreach ($stats as $k => $v): ?>
    <div class="col-6 col-md-4 col-lg-3">
      <div class="card border-0 shadow-sm text-center">
        <div class="card-body">
          <div class="h4 text-success"><?= (int)$v ?></div>
          <div class="small text-muted"><?= ucfirst($k) ?></div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>
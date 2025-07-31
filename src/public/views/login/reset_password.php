<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-5">
      <div class="card shadow">
        <div class="card-body">
          <?php if (!isset($_SESSION['codigo_valido'])): ?>
            <h3 class="mb-4 text-center">Ingresa el código</h3>
            <form method="post">
              <input type="hidden" name="action" value="validate_code">
              <div class="mb-3">
                <label for="codigo">Código recibido</label>
                <input type="number" name="codigo" class="form-control" required>
              </div>
              <button type="submit" class="btn btn-primary w-100">Validar código</button>
            </form>
          <?php else: ?>
            <h3 class="mb-4 text-center">Nueva contraseña</h3>
            <form method="post">
              <input type="hidden" name="action" value="save_password">
              <div class="mb-3">
                <label for="password">Nueva contraseña</label>
                <input type="password" name="password" class="form-control" required minlength="6">
              </div>
              <div class="mb-3">
                <label for="password_confirm">Confirmar contraseña</label>
                <input type="password" name="password_confirm" class="form-control" required minlength="6">
              </div>
              <button type="submit" class="btn btn-success w-100">Guardar contraseña</button>
            </form>
          <?php endif; ?>

          <?php
          if (isset($_SESSION['error'])) {
            $showAlert($_SESSION['error'], "danger");
            unset($_SESSION['error']);
          }
          ?>
        </div>
      </div>
    </div>
  </div>
</div>
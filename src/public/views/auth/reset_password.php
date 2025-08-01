<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-5">
      <div class="card shadow">
        <div class="card-body">
          <?php if (!isset($_SESSION['is_code_valid'])): ?>
            <h3 class="mb-4 text-center">Ingresa el código</h3>
            <form method="post">
              <input type="hidden" name="action" value="validate_code">
              <div class="mb-3">
                <label for="code">Código recibido</label>
                <input type="number" name="code" class="form-control" required>
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
                <label for="confirm_password">Confirmar contraseña</label>
                <input type="password" name="confirm_password" class="form-control" required minlength="6">
              </div>
              <button type="submit" class="btn btn-success w-100">Guardar contraseña</button>
            </form>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>
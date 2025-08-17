<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-5">
      <div class="card shadow">
        <div class="card-body">
          <?php if (!isset($_SESSION['is_code_valid'])): ?>
            <h3 class="fw-bold mb-2 text-center">Ingresa el código</h3>
            <p class="text-muted text-center mb-4">
              Revisa tu correo y escribe el código de verificación que recibiste.
            </p>
            <form method="post">
              <input type="hidden" name="action" value="validate_code">
              <div class="mb-3">
                <label for="code" class="form-label">Código recibido</label>
                <input type="number" name="code" id="code" class="form-control" placeholder="Ej: 123456" required>
              </div>
              <button type="submit" class="btn btn-primary w-100">Validar código</button>
              <div class="text-center mt-3">
                <a href="forgot_password.php"><i class="bi bi-arrow-left"></i> Reenviar o cambiar correo</a>
              </div>
            </form>
          <?php else: ?>
            <h3 class="fw-bold mb-2 text-center">Nueva contraseña</h3>
            <p class="text-muted text-center mb-4">
              Escribe tu nueva contraseña y confírmala para completar el proceso.
            </p>
            <form method="post">
              <input type="hidden" name="action" value="save_password">
              <div class="mb-3">
                <label for="password" class="form-label">Nueva contraseña</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required minlength="6">
              </div>
              <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirmar contraseña</label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="••••••••" required minlength="6">
              </div>
              <button type="submit" class="btn btn-success w-100">Guardar contraseña</button>
              <div class="text-center mt-3">
                <a href="login.php"><i class="bi bi-box-arrow-in-right"></i> Volver al inicio de sesión</a>
              </div>
            </form>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

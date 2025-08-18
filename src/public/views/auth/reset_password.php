<div class="row justify-content-center align-items-center">
  <div class="col-12 col-sm-10 col-md-8 col-lg-6">
    <div class="card page-card" role="region" aria-labelledby="reset-title">
      <div class="card-body p-4 p-md-5">
        <?php if (!isset($_SESSION['is_code_valid'])): ?>
          <div class="text-center mb-4">
            <h3 id="page-title" class="fw-bold">Ingresa el código</h3>
            <p class="text-muted small mb-0">Revisa tu correo y escribe el código de verificación que recibiste.</p>
          </div>

          <form method="post" id="validateCodeForm">
            <input type="hidden" name="action" value="validate_code">
            <div class="mb-3">
              <label class="form-label" for="code">Código recibido</label>
              <div class="input-group input-ghost">
                <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                <input id="code" type="text" name="code" class="form-control" placeholder="Ej: 123456" inputmode="numeric" pattern="\d{6}" maxlength="6" required autocomplete="one-time-code" />
              </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">Validar código</button>

            <div class="mt-3 text-center">
              <a href="forgot_password.php" class="text-decoration-none"><i class="bi bi-arrow-left"></i> Reenviar o cambiar correo</a>
            </div>
          </form>
        <?php else: ?>
          <div class="text-center mb-4">
            <h3 id="page-title" class="fw-bold">Nueva contraseña</h3>
            <p class="text-muted small mb-0">Escriba su nueva contraseña y confírmela para completar el proceso.</p>
          </div>

          <form method="post" id="savePasswordForm">
            <input type="hidden" name="action" value="save_password">
            <div class="mb-3">
              <label class="form-label" for="password">Nueva contraseña</label>
              <div class="input-group passwordField">
                <span class="input-group-text bg-white"><i class="bi bi-lock"></i></span>
                <input id="password" type="password" name="password" class="form-control" placeholder="********" required minlength="6" autocomplete="new-password" />
                <button type="button" id="toggleFirst" class="togglePassword" class="btn btn-outline-secondary">
                  <i class="bi bi-eye"></i>
                </button>
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label" for="confirm_password">Confirmar contraseña</label>
              <div class="input-group passwordField">
                <span class="input-group-text bg-white"><i class="bi bi-lock-fill"></i></span>
                <input id="confirm_password" type="password" name="confirm_password" class="form-control" placeholder="********" required minlength="6" autocomplete="new-password" />
                <button type="button" id="toggleConfirm" class="togglePassword" class="btn btn-outline-secondary">
                  <i class="bi bi-eye"></i>
                </button>
              </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">Guardar contraseña</button>

            <div class="mt-3 text-center">
              <a href="login.php" class="text-decoration-none"><i class="bi bi-box-arrow-in-right"></i> Volver al inicio</a>
            </div>
          </form>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
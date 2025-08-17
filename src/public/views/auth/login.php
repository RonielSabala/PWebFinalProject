<div class="row justify-content-center" style="min-height: 80vh;">
    <div class="col-md-6">
        <div class="card shadow-lg border-0">
            <div class="card-body p-6">
                <div class="text-center mb-5">
                    <h3 class="fw-bold">Iniciar Sesión</h3>
                    <p class="text-muted small">Accede con tu cuenta</p>
                </div>

                <!-- Login manual -->
                <form method="post">
                    <!-- Email -->
                    <div class="mb-3">
                        <label class="form-label" for="email">Correo electrónico</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="bi bi-envelope"></i></span>
                            <input type="email" id="email" name="email" class="form-control" placeholder="tucorreo@ejemplo.com" required>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label class="form-label" for="password">Contraseña</label>
                        <div class="input-group passwordField">
                            <span class="input-group-text bg-white"><i class="bi bi-lock"></i></span>
                            <input type="password" id="password" name="password" class="form-control" placeholder="********" required>
                            <button type="button" id="togglePassword" class="btn btn-outline-secondary">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Botón -->
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">Ingresar</button>
                </form>

                <div class="mt-3 text-end">
                    <a href="forgot_password.php" class="small text-decoration-none">¿Olvidaste tu contraseña?</a>
                </div>

                <hr>

                <!-- Opciones de autenticación externa -->
                <div class="text-center">
                    <p class="mb-2 small">¿No tienes cuenta? <a href="signin.php" class="fw-bold">Regístrate</a></p>
                    <a href="<?= $google_auth_url ?>" class="btn btn-danger w-100 mb-2">
                        <i class="bi bi-google me-1"></i> Google
                    </a>
                    <a href="MicrosoftController.php" class="btn btn-primary w-100">
                        <i class="bi bi-microsoft me-1"></i> Microsoft
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

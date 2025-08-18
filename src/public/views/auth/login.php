<div class="row justify-content-center align-items-center">
    <div class="col-12 col-sm-10 col-md-8 col-lg-6">
        <div class="card page-card" role="region">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <h3 id="page-title" class="fw-bold">Inicia Sesión</h3>
                    <p class="text-muted small">Accede con tu cuenta.</p>
                </div>

                <!-- Login manual -->
                <form id="loginForm" method="post">
                    <!-- Email -->
                    <div class="mb-3">
                        <label class="form-label" for="email">Correo electrónico</label>
                        <div class="input-group input-ghost">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input id="email" type="email" name="email" class="form-control" placeholder="tucorreo@ejemplo.com" required autocomplete="email" />
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label class="form-label" for="password">Contraseña</label>
                        <div class="input-group passwordField">
                            <span class="input-group-text bg-white"><i class="bi bi-lock"></i></span>
                            <input id="password" type="password" name="password" class="form-control" placeholder="********" required autocomplete="new-password" />
                            <button type="button" id="togglePassword" class="btn btn-outline-secondary" aria-label="Mostrar contraseña">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Botón -->
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">Ingresar</button>
                </form>

                <div class="mt-3 d-flex justify-content-between align-items-center">
                    <a href="forgot_password.php" class="small text-decoration-none">¿Olvidaste tu contraseña?</a>
                    <a href="signin.php" class="small text-decoration-none fw-bold">¿No tienes cuenta? Regístrate</a>
                </div>

                <hr class="login-hr my-4">

                <!-- Opciones de autenticación externa -->
                <div class="text-center">
                    <a href="<?= $google_auth_url ?>" id="btn-google" class="btn btn-social w-100 mb-2">
                        <i class="bi bi-google me-2"></i> Continuar con Google
                    </a>
                    <a href="MicrosoftController.php" id="btn-microsoft" class="btn btn-social w-100">
                        <i class="bi bi-microsoft me-2"></i> Continuar con Microsoft
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row justify-content-center align-items-center">
    <div class="col-12 col-sm-10 col-md-8 col-lg-7">
        <div class="card page-card">
            <div class="card-body p-md-5">
                <div class="text-center mb-4">
                    <div class="heading-with-icon d-inline-flex align-items-center">
                        <div class="text-block text-start">
                            <h3 id="page-title" class="fw-bold mt-2 mb-1">Crea tu cuenta</h3>
                            <p class="text-muted mb-0">Regístrate para gestionar tus incidencias y acceder a tus herramientas.</p>
                        </div>
                        <i class="bi bi-person-plus-fill icon text-success ms-3" title="Crear usuario" aria-hidden="true"></i>
                    </div>
                </div>

                <form method="post">
                    <!-- Nombre -->
                    <div class="mb-3">
                        <label class="form-label" for="username">Nombre</label>
                        <div class="input-group input-ghost">
                            <span class="input-group-text" aria-hidden="true"><i class="bi bi-person"></i></span>
                            <input id="username" type="text" name="username" class="form-control" placeholder="Tu nombre completo" required autocomplete="name" />
                        </div>
                    </div>

                    <!-- Correo electrónico -->
                    <div class="mb-3">
                        <label class="form-label" for="email">Email</label>
                        <div class="input-group input-ghost">
                            <span class="input-group-text" aria-hidden="true"><i class="bi bi-envelope"></i></span>
                            <input id="email" type="email" name="email" class="form-control" placeholder="correo@ejemplo.com" required autocomplete="email" />
                        </div>
                    </div>

                    <!-- Teléfono -->
                    <div class="mb-3">
                        <label class="form-label" for="phone">Teléfono</label>
                        <div class="input-group input-ghost">
                            <span class="input-group-text" aria-hidden="true"><i class="bi bi-telephone"></i></span>
                            <input id="phone" type="tel" name="phone" class="form-control"
                                placeholder="+1 809 000 0000" inputmode="tel" pattern="[\d+\s()-]{7,}" autocomplete="tel" required />
                        </div>
                        <div class="form-text">Formato sugerido: +1 809 000 0000</div>
                    </div>

                    <!-- Contraseña -->
                    <div class="mb-3">
                        <label class="form-label" for="signupPassword">Contraseña</label>
                        <div class="input-group passwordField">
                            <span class="input-group-text bg-white" aria-hidden="true"><i class="bi bi-lock"></i></span>
                            <input id="signupPassword" type="password" name="password" class="form-control" placeholder="********" required autocomplete="new-password" />
                            <button type="button" id="togglePassword" class="btn btn-outline-secondary" aria-label="Mostrar contraseña">
                                <i class="bi bi-eye" aria-hidden="true"></i>
                            </button>
                        </div>
                        <div class="form-text">Mínimo 8 caracteres. Usa letras y números para mayor seguridad.</div>
                    </div>

                    <div class="mb-3 form-check">
                        <input id="terms" class="form-check-input" type="checkbox" required />
                        <label class="form-check-label small" for="terms">Acepto los <a href="#" class="text-decoration-none">Términos y Condiciones</a>.</label>
                    </div>

                    <button type="submit" class="btn btn-success w-100 py-2 fw-semibold">Registrarse</button>
                </form>

                <hr class="my-4">

                <!-- Opciones de autenticación externa -->
                <div class="text-center">
                    <a href="<?= $google_auth_url ?>" class="btn btn-social btn-google w-100 mb-2">
                        <i class="bi bi-google me-2"></i> Continuar con Google
                    </a>
                    <a href="MicrosoftController.php" class="btn btn-social btn-microsoft w-100">
                        <i class="bi bi-microsoft me-2"></i> Continuar con Microsoft
                    </a>
                </div>

                <div class="text-center mt-3">
                    <a href="login.php">¿Ya tienes cuenta? Inicia sesión</a>
                </div>
            </div>
        </div>
    </div>
</div>
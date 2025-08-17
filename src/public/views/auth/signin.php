<div class="row justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="col-md-6">
        <div class="card shadow-lg border-0">
            <div class="card-body p-6">
                <div class="text-center mb-4">
                    <div class="heading-with-icon d-inline-flex align-items-center">
                        <div class="text-block text-start">
                            <h3 class="fw-bold mt-2 mb-1">Registro de Usuario</h3>
                            <p class="text-muted mb-0">Crea tu cuenta para comenzar</p>
                        </div>
                        <i class="bi bi-person-plus-fill icon text-success ms-3" title="Crear usuario" style="font-size: 3rem"></i>
                    </div>
                </div>

                <form method="post">
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" name="username" class="form-control" placeholder="Tu nombre completo" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" name="email" class="form-control" placeholder="correo@ejemplo.com" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Teléfono</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                            <input type="tel" name="phone" class="form-control" placeholder="+1 809 000 0000" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" name="password" class="form-control" placeholder="********" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success w-100 py-2 fw-semibold">Registrarse</button>
                </form>

                <hr class="my-4">

                <div class="text-center">
                    <a href="<?= $google_auth_url ?>" class="btn btn-outline-danger w-100 mb-2">
                        <i class="bi bi-google me-2"></i> Registrarse con Google
                    </a>
                    <a href="MicrosoftController.php" class="btn btn-outline-primary w-100">
                        <i class="bi bi-microsoft me-2"></i> Registrarse con Microsoft
                    </a>
                </div>

                <div class="text-center mt-3">
                    <a href="login.php">¿Ya tienes cuenta? Inicia sesión</a>
                </div>
            </div>
        </div>
    </div>
</div>

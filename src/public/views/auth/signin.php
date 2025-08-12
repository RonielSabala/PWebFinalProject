<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6"> <!-- Más ancho en medianas, ajustado en grandes -->
            <div class="card shadow-lg border-0">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <i class="bi bi-person-plus-fill text-success fs-1"></i>
                        <h3 class="fw-bold mt-2">Registro de Usuario</h3>
                        <p class="text-muted">Crea tu cuenta para comenzar</p>
                    </div>

                    <form method="post">
                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="bi bi-person"></i></span>
                                <input type="text" name="username" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Teléfono</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="bi bi-telephone"></i></span>
                                <input type="tel" name="phone" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Contraseña</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="bi bi-lock"></i></span>
                                <input type="password" name="password" class="form-control" required>
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
</div>

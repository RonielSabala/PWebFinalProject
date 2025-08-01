<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">
                    <h3 class="text-center mb-4">Registro de Usuario</h3>
                    <form method="post">
                        <div class="mb-3">
                            <label>Nombre</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Teléfono</label>
                            <input type="phone" name="phone" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Contraseña</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Registrarse</button>
                    </form>
                    <hr class="my-4">

                    <!-- Opciones de autenticación externa -->
                    <div class="text-center">
                        <a href="<?= $google_auth_url ?>" class="btn btn-outline-danger w-100 mb-2">Google</a>
                        <a href="MicrosoftController.php" class="btn btn-outline-primary w-100">Microsoft</a>
                    </div>

                    <div class="text-center mt-3">
                        <a href="login.php">¿Ya tienes cuenta? Inicia sesión</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow">
            <div class="card-body">
                <h3 class="text-center mb-4">Iniciar Sesión</h3>

                <!-- Login manual -->
                <form method="post">
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3 position-relative">
                        <label>Contraseña</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                        <button type="button" id="togglePassword"
                            style="position: absolute; right: 10px; top: 38px; background:none; border:none;">
                            👁️
                        </button>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Ingresar</button>
                </form>

                <div class="mt-2 text-end">
                    <a href="forgot_password.php">¿Olvidaste tu contraseña?</a>
                </div>

                <hr>

                <!-- Opciones de autenticación externa -->
                <div class="text-center">
                    <p>¿No tienes cuenta? <a href="signin.php">Regístrate</a></p>
                    <a href="<?= $google_auth_url ?>" class="btn btn-outline-danger w-100 mb-2">Google</a>
                    <a href="MicrosoftController.php" class="btn btn-outline-primary w-100">Microsoft</a>
                </div>
            </div>
        </div>
    </div>
</div>
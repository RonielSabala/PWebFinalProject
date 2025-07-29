<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">
                    <h3 class="text-center mb-4">Registro de Usuario</h3>
                    <form method="post">
                        <div class="mb-3">
                            <label>Nombre</label>
                            <input type="text" name="nombre" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Teléfono</label>
                            <input type="text" name="telefono" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Contraseña</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Registrarse</button>
                    </form>
                    <hr class="my-4">
                    <div class="text-center">
                        <?= $google_button ?>
                        <?= $microsoft_button ?>
                    </div>
                    <div class="text-center mt-3">
                        <a href="login.php">¿Ya tienes cuenta? Inicia sesión aquí</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
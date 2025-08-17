<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-body">
                    <h3 class="fw-bold mb-2 text-center">Recuperar contraseña</h3>
                    <p class="text-muted text-center mb-4">
                        Ingresa tu correo electrónico y te enviaremos un código de verificación.
                    </p>

                    <form method="post">
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo electrónico</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="ejemplo@correo.com" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Enviar código</button>

                        <div class="text-center mt-3">
                            <a href="login.php"><i class="bi bi-arrow-left"></i> Volver al inicio de sesión</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

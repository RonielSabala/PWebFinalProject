<div class="row justify-content-center align-items-center">
    <div class="col-12 col-sm-10 col-md-8 col-lg-6">
        <div class="card page-card" role="region" aria-labelledby="page-title">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <h3 id="page-title" class="fw-bold">Recuperar contraseña</h3>
                    <p class="text-muted small">Introduce tu correo y te enviaremos un código para restablecerla</p>
                </div>

                <form id="forgotForm" method="post" novalidate>
                    <div class="mb-3">
                        <label class="form-label" for="forgotEmail">Correo electrónico</label>
                        <div class="input-group input-ghost">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input id="forgotEmail" type="email" name="email" class="form-control" placeholder="tucorreo@ejemplo.com" required autocomplete="email" />
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">Enviar código</button>
                </form>

                <div class="mt-3 text-center">
                    <a href="login.php" class="small text-decoration-none"><i class="bi bi-box-arrow-in-right"></i> Volver al inicio</a>
                </div>
            </div>
        </div>
    </div>
</div>
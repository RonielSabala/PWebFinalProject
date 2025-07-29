<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Olvidé mi contraseña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow">
                    <div class="card-body">
                        <h3 class="mb-4 text-center">Recuperar contraseña</h3>
                        <form method="post">
                            <input type="hidden" name="accion" value="enviar_codigo">
                            <div class="mb-3">
                                <label for="email">Correo electrónico</label>
                                <input type="email" name="email" id="email" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Enviar código</button>
                            <div class="text-center mt-3"><a href="login.php">Volver</a></div>
                        </form>
                        <?php
                        if (isset($_SESSION['error'])) {
                            echo '<div class="alert alert-danger mt-3">' . $_SESSION['error'] . '</div>';
                            unset($_SESSION['error']);
                        }
                        if (isset($_SESSION['success'])) {
                            echo '<div class="alert alert-success mt-3">' . $_SESSION['success'] . '</div>';
                            unset($_SESSION['success']);
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
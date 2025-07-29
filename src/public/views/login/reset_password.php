<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Restablecer contraseña</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-5">
        <div class="card shadow">
          <div class="card-body">
            <?php if (!isset($_SESSION['codigo_valido'])): ?>
              <h3 class="mb-4 text-center">Ingresa el código</h3>
              <form method="post">
                <input type="hidden" name="accion" value="validar_codigo">
                <div class="mb-3">
                  <label for="codigo">Código recibido</label>
                  <input type="number" name="codigo" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Validar código</button>
              </form>
            <?php else: ?>
              <h3 class="mb-4 text-center">Nueva contraseña</h3>
              <form method="post">
                <input type="hidden" name="accion" value="guardar_contrasena">
                <div class="mb-3">
                  <label for="password">Nueva contraseña</label>
                  <input type="password" name="password" class="form-control" required minlength="6">
                </div>
                <div class="mb-3">
                  <label for="password_confirm">Confirmar contraseña</label>
                  <input type="password" name="password_confirm" class="form-control" required minlength="6">
                </div>
                <button type="submit" class="btn btn-success w-100">Guardar contraseña</button>
              </form>
            <?php endif; ?>

            <?php
            if (isset($_SESSION['error'])) {
              echo '<div class="alert alert-danger mt-3">' . $_SESSION['error'] . '</div>';
              unset($_SESSION['error']);
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
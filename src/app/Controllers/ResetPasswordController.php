<?php

namespace App\Controllers;

use App\Core\Template;
use App\Helpers\Utils;

class ResetPasswordController
{
    public function handle(Template $template, $pdo)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($_POST['action'] == "validate_code") {
                $codigo = trim($_POST['codigo'] ?? '');

                // ¿Existe código en sesión y no expiró?
                if (!isset($_SESSION['reset_codigo']) || time() > $_SESSION['reset_expira']) {
                    $_SESSION['error'] = "Código expirado. Vuelve a solicitarlo.";
                    header('Location: forgot_password.php');
                    exit;
                } elseif ($codigo == $_SESSION['reset_codigo']) {
                    $_SESSION['codigo_valido'] = true;
                } else {
                    $_SESSION['error'] = "Código incorrecto.";
                }

                header('Location: reset_password.php');
                exit;
            }

            // Sólo si el código fue validado
            if (empty($_SESSION['codigo_valido'])) {
                $_SESSION['error'] = "Acceso no autorizado.";
                header('Location: forgot_password.php');
                exit;
            }

            $password = $_POST['password'] ?? '';
            $confirm  = $_POST['password_confirm'] ?? '';
            if ($password !== $confirm) {
                $_SESSION['error'] = "Las contraseñas no coinciden.";
                header('Location: reset_password.php');
                exit;
            }

            // Hashear y actualizar con PDO
            $sql = "UPDATE usuarios SET password_hash = :pass WHERE email = :email";
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $email  = $_SESSION['reset_email'];
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':pass',  $hashed, \PDO::PARAM_STR);
            $stmt->bindParam(':email', $email,  \PDO::PARAM_STR);
            if ($stmt->execute()) {
                // Limpiar sesión
                unset(
                    $_SESSION['reset_codigo'],
                    $_SESSION['reset_expira'],
                    $_SESSION['reset_email'],
                    $_SESSION['codigo_valido']
                );

                header('Location: login.php');
            } else {
                $_SESSION['error'] = "Error al guardar la contraseña. Intenta de nuevo.";
                header('Location: reset_password.php');
            }

            exit;
        }

        $template->apply([
            'pdo' => $pdo,
            'showAlert' => [Utils::class, 'showAlert'],
        ]);
    }
}

<?php

namespace App\Controllers\Login;

use App\Core\Template;
use App\Utils\UserUtils;


class ResetPasswordController
{
    public function handle(Template $template)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $template->apply();
            exit;
        }

        if ($_POST['action'] == "validate_code") {
            $code = trim($_POST['code'] ?? '');

            // ¿Existe código en sesión y no expiró?
            if (!isset($_SESSION['reset_password_code']) || time() > $_SESSION['reset_password_expiration']) {
                $_SESSION['error'] = "Código expirado. Vuelve a solicitarlo.";
                header('Location: forgot_password.php');
                exit;
            } elseif ($code == $_SESSION['reset_password_code']) {
                $_SESSION['is_code_valid'] = true;
            } else {
                $_SESSION['error'] = "Código incorrecto.";
            }

            header('Location: reset_password.php');
            exit;
        }

        // Validar código
        if (empty($_SESSION['is_code_valid'])) {
            $_SESSION['error'] = "Acceso no autorizado.";
            header('Location: forgot_password.php');
            exit;
        }

        // Validar contraseñas
        $password = $_POST['password'] ?? '';
        $confirm_password  = $_POST['confirm_password'] ?? '';
        if ($password !== $confirm_password) {
            $_SESSION['error'] = "Las contraseñas no coinciden.";
            header('Location: reset_password.php');
            exit;
        }

        // Datos del usuario a usar
        $email  = $_SESSION['reset_password_email'];
        $new_password = password_hash($password, PASSWORD_DEFAULT);

        // Actualizar contraseña
        $success = UserUtils::updatePassword($email, $new_password);
        if (!$success) {
            $_SESSION['error'] = "Error al guardar la contraseña. Intenta de nuevo.";
            header('Location: reset_password.php');
            exit;
        }

        // Limpiar sesión
        unset(
            $_SESSION['reset_password_email'],
            $_SESSION['reset_password_code'],
            $_SESSION['reset_password_expiration'],
            $_SESSION['is_code_valid']
        );

        // Registrar sesión
        $usuario = UserUtils::get($email);
        $_SESSION['usuario'] = [
            'id'     => $usuario['id'],
            'nombre' => $usuario['nombre'],
            'email'  => $usuario['email'],
            'rol'    => $usuario['rol'],
        ];

        // Redirigir al index
        header("Location: /../index.php");
    }
}

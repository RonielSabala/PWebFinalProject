<?php

namespace App\Controllers\Login;

use App\Core\Template;
use App\Utils\UserUtils;
use App\Utils\GenericUtils;


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
            if (!isset($_SESSION['reset_password_code']) || time() > $_SESSION['reset_password_code_expiration_time']) {
                GenericUtils::showAlert("Código expirado. Vuelve a solicitarlo.", "danger", returnRoute: "forgot_password.php");
                $template->apply();
            } elseif ($code == $_SESSION['reset_password_code']) {
                $_SESSION['is_code_valid'] = true;
                header('Location: reset_password.php');
            } else {
                GenericUtils::showAlert("Código incorrecto.", "danger", false);
                $template->apply();
            }

            exit;
        }

        // Validar código
        if (empty($_SESSION['is_code_valid'])) {
            GenericUtils::showAlert("Acceso no autorizado.", "danger", returnRoute: "forgot_password.php");
            $template->apply();
            exit;
        }

        // Validar contraseñas
        $password = $_POST['password'] ?? '';
        $confirm_password  = $_POST['confirm_password'] ?? '';
        if ($password !== $confirm_password) {
            GenericUtils::showAlert("Las contraseñas no coinciden.", "danger", false);
            $template->apply();
            exit;
        }

        // Actualizar contraseña
        $email = $_SESSION['reset_password_email'];
        $new_password = password_hash($password, PASSWORD_DEFAULT);
        $success_response = UserUtils::updatePassword($email, $new_password);
        if (!$success_response) {
            GenericUtils::showAlert("Error al actualizar la contraseña. Intenta de nuevo.", "danger", false);
            $template->apply();
            exit;
        }

        // Limpiar sesión
        session_unset();

        // Registrar sesión
        $user = UserUtils::get_by($email);
        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'email' => $user['email'],
            'role_name' => $user['role_name'],
        ];

        // Redirigir al index
        header("Location: /../index.php");
    }
}

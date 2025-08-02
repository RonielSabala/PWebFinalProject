<?php

namespace App\Controllers\Auth;

use App\Core\Template;
use App\Utils\GeneralUtils;
use App\Utils\Entities\UserUtils;


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
                GeneralUtils::showAlert("Código expirado. Vuelve a solicitarlo.", "danger",  "forgot_password.php");
                $template->apply();
            } elseif ($code == $_SESSION['reset_password_code']) {
                $_SESSION['is_code_valid'] = true;
                header('Location: reset_password.php');
            } else {
                GeneralUtils::showAlert("Código incorrecto.", "danger", showReturn: false);
                $template->apply();
            }

            exit;
        }

        // Validar código
        if (empty($_SESSION['is_code_valid'])) {
            GeneralUtils::showAlert("Acceso no autorizado.", "danger", "forgot_password.php");
            $template->apply();
            exit;
        }

        // Validar contraseñas
        $password = $_POST['password'] ?? '';
        $confirm_password  = $_POST['confirm_password'] ?? '';
        if ($password !== $confirm_password) {
            GeneralUtils::showAlert("Las contraseñas no coinciden.", "danger", showReturn: false);
            $template->apply();
            exit;
        }

        // Actualizar contraseña
        $email = $_SESSION['reset_password_email'];
        $new_password = password_hash($password, PASSWORD_DEFAULT);
        $success = UserUtils::updatePassword($email, $new_password);
        if (!$success) {
            GeneralUtils::showAlert("Error al actualizar la contraseña. Intenta de nuevo.", "danger", showReturn: false);
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
        header("Location: /index.php");
    }
}

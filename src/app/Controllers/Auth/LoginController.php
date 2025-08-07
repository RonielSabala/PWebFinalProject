<?php

namespace App\Controllers\Auth;

use App\Core\Template;
use App\Utils\OAuthUtils;
use App\Utils\GeneralUtils;
use App\Utils\Entities\UserUtils;


class LoginController
{
    public static function log_user()
    {
        // Tipos de acceso
        $by_post = $_SERVER['REQUEST_METHOD'] === 'POST';
        $by_signin = isset($_POST['username']);
        $by_external_service = isset($_SESSION['user']);

        // Verificar interacción con el login
        if (!($by_post || $by_external_service)) {
            return false;
        }

        // Obtener sesión correspondiente
        if ($by_post) {
            // Registro manual
            $user_session = $_POST;
        } else {
            // Registro con Google/Microsoft
            $user_session = $_SESSION['user'];
            $user_session['phone'] = '0000000000';
            $user_session['password'] = 'oauth123';
        }

        // Limpiar sesión
        session_unset();

        // Datos del usuario
        $username = $user_session['username'] ?? '';
        $email = $user_session['email'];
        $phone = $user_session['phone'] ?? '';
        $password = $user_session['password'];

        // Comprobar si el usuario existe
        $user_exists = UserUtils::exists($email);
        if ($user_exists) {
            // Evitar registro si el usuario ya existe
            if ($by_signin) {
                GeneralUtils::showAlert("El correo proporcionado ya se encuentra registrado.", "danger", showReturn: false);
                return false;
            }
        } elseif ($by_signin || $by_external_service) {
            // Registrar usuario
            UserUtils::create([$username, $email, $phone, password_hash($password, PASSWORD_DEFAULT)]);
        } else {
            GeneralUtils::showAlert("El correo proporcionado no está registrado.", "danger", showReturn: false);
            return false;
        }

        // Recuperar usuario
        $user = UserUtils::get_by($email);

        // Verificar contraseña
        $user_password = $user['password_hash'];
        $is_valid_pass = $by_external_service || password_verify($password, $user_password);
        if ($user_exists && !$is_valid_pass) {
            GeneralUtils::showAlert("Credenciales incorrectas!", "danger", showReturn: false);
            return false;
        }

        // Registrar sesión
        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'email' => $user['email'],
            'role_name' => $user['role_name'],
        ];

        // Redirigir al index
        header("Location: /index.php");
        return true;
    }

    public function handle(Template $template)
    {
        if (self::log_user()) {
            exit;
        }

        $template->apply([
            'google_auth_url' => OAuthUtils::getGoogleUrl(),
        ]);
    }
}

<?php

namespace App\Controllers\Login;

use App\Core\Template;
use App\Utils\UserUtils;
use App\Utils\OAuthUtils;
use App\Utils\GenericUtils;


class LoginController
{
    static public function log_user()
    {
        // Tipos de acceso
        $by_post = $_SERVER['REQUEST_METHOD'] === 'POST';
        $by_signin = isset($_POST['username']);
        $by_google = isset($_SESSION['google_user']);
        $by_microsoft = isset($_SESSION['microsoft_user']);

        // Verificar al menos una condición se cumple
        if (!($by_post || $by_google || $by_microsoft)) {
            return false;
        }

        // Obtener sesión correspondiente
        if ($by_post) {
            // Registro manual
            $user_session = $_POST;
        } else {
            // Registro con Google/Microsoft
            $user_session = $by_google ? $_SESSION['google_user'] : $_SESSION['microsoft_user'];
            $user_session['phone'] = '0000000000';
            $user_session['password'] = 'oauth123';

            // Limpiar sesión
            unset($_SESSION['google_user'], $_SESSION['google_access_token'], $_SESSION['microsoft_user']);
        }

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
                GenericUtils::showAlert("El correo proporcionado ya se encuentra registrado.", "danger", returnRoute: "signin.php");
                return false;
            }
        } elseif ($by_signin || $by_google || $by_microsoft) {
            // Registrar usuario
            UserUtils::create($username, $email, $phone, $password);
        } else {
            GenericUtils::showAlert("El correo proporcionado no está registrado.", "danger", false);
            return false;
        }

        // Recuperar datos del usuario
        $user = UserUtils::get_by($email);

        // Verificar contraseña
        $user_password = $user['password_hash'];
        $is_valid_pass = $by_google || $by_microsoft || password_verify($password, $user_password);
        if ($user_exists && !$is_valid_pass) {
            GenericUtils::showAlert("Credenciales incorrectas!", "danger", false);
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
        header("Location: /../index.php");
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

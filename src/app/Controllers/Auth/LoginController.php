<?php

namespace App\Controllers\Auth;

use App\Core\Template;
use App\Utils\OAuthUtils;
use App\Utils\GeneralUtils;
use App\Utils\Entities\UserUtils;


class LoginController
{
    public static function logUser()
    {
        // Tipos de acceso
        $byPost = $_SERVER['REQUEST_METHOD'] === 'POST';
        $bySignin = isset($_POST['username']);
        $byExternalService = isset($_SESSION['user']);

        // Verificar que se mandó el formulario
        if (!($byPost || $byExternalService)) {
            return '';
        }

        // Obtener sesión correspondiente
        if ($byPost) {
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
            if ($bySignin) {
                return 'El correo proporcionado ya se encuentra registrado.';
            }
        } elseif ($bySignin || $byExternalService) {
            // Registrar usuario
            $response = UserUtils::create([$username, $email, $phone, password_hash($password, PASSWORD_DEFAULT)]);

            if (!$response) {
                return 'Error al crear usuario.';
            }
        } else {
            return 'El correo proporcionado no está registrado.';
        }

        // Recuperar usuario
        $user = UserUtils::getByEmail($email);

        // Verificar contraseña
        $user_password = $user['password_hash'];
        $is_valid_pass = $byExternalService || password_verify($password, $user_password);
        if ($user_exists && !$is_valid_pass) {
            return 'Credenciales incorrectas!';
        }

        // Registrar sesión
        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'email' => $user['email'],
            'role_name' => $user['role_name'],
        ];

        // Redirigir al home
        header('Location: /home.php');
        return true;
    }

    public function handle(Template $template)
    {
        $response = self::logUser();

        // Login exitoso
        if ($response === true) {
            exit;
        }

        $template->apply([
            'google_auth_url' => OAuthUtils::getGoogleUrl(),
        ]);

        if (is_string($response) && !empty($response)) {
            GeneralUtils::showAlert($response, showReturn: false);
        }
    }
}

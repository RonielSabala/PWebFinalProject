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
        $por_post = $_SERVER['REQUEST_METHOD'] === 'POST';
        $por_signin = isset($_POST['nombre']);
        $por_google = isset($_SESSION['google_user']);
        $por_microsoft = isset($_SESSION['microsoft_user']);

        // Verificar al menos una condición se cumple
        if (!($por_post || $por_google || $por_microsoft)) {
            return false;
        }

        // Obtener sesión correspondiente
        if ($por_post) {
            // Registro manual
            $session = $_POST;
        } else {
            // Registro con Google/Microsoft
            $session = $por_google ? $_SESSION['google_user'] : $_SESSION['microsoft_user'];
            $session['telefono'] = '0000000000';
            $session['password'] = 'oauth123';

            // Limpiar sesión
            unset($_SESSION['google_user'], $_SESSION['google_access_token'], $_SESSION['microsoft_user']);
        }

        // Datos del usuario
        $nombre = $session['nombre'] ?? '';
        $email = $session['email'];
        $telefono = $session['telefono'] ?? '';
        $password = $session['password'];

        $usuario_existe = UserUtils::exists($email);
        if ($usuario_existe) {
            // Evitar registro si el usuario ya existe
            if ($por_signin) {
                GenericUtils::showAlert("El correo ya se encuentra registrado.", "danger", returnRoute: "signin.php");
                return false;
            }
        } elseif ($por_signin || $por_google || $por_microsoft) {
            // Registrar usuario
            UserUtils::create($nombre, $email, $telefono, $password);
        } else {
            GenericUtils::showAlert("El correo no está registrado.", "danger", false);
            return false;
        }

        $usuario = UserUtils::get($email);

        // Verificar contraseña
        $es_valida = $por_google || $por_microsoft || password_verify($password, $usuario['password_hash']);
        if ($usuario_existe && !$es_valida) {
            GenericUtils::showAlert("Credenciales incorrectas!", "danger", false);
            return false;
        }

        // Registrar sesión
        $_SESSION['usuario'] = [
            'id'     => $usuario['id'],
            'nombre' => $usuario['nombre'],
            'email'  => $usuario['email'],
            'rol'    => $usuario['rol'],
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

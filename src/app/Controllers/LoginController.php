<?php

namespace App\Controllers;

use App\Core\Template;
use App\Helpers\Utils;
use PDO;


class LoginController
{
    static public function validate_sesion($pdo)
    {
        // Tipos de acceso
        $por_post      = $_SERVER['REQUEST_METHOD'] === 'POST';
        $por_signin    = isset($_POST['nombre']);
        $por_google    = isset($_SESSION['google_user']);
        $por_microsoft = isset($_SESSION['microsoft_user']);
        if (!($por_post || $por_google || $por_microsoft)) {
            return false;
        }

        // Registro manual
        if ($por_post) {
            $nombre   = $_POST['nombre'] ?? "";
            $email    = $_POST['email'];
            $telefono = $_POST['telefono'] ?? "";
            $password = $_POST['password'];

            // Registro con Google
        } elseif ($por_google) {
            $nombre = $_SESSION['google_user']['first_name'] . ' ' . $_SESSION['google_user']['last_name'];
            $email = $_SESSION['google_user']['email'];
            $telefono = '0000000000';
            $password = "oauth123";

            // Registro con Microsoft
        } else {
            $nombre = $_SESSION['microsoft_user']['name'];
            $email = $_SESSION['microsoft_user']['email'];
            $telefono = '0000000000';
            $password = "oauth123";
        }

        // 1) Verificar si existe usuario
        $sql = "SELECT 1 FROM usuarios WHERE email = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        $usuario_existe = $stmt->fetchColumn() ? true : false;

        if ($usuario_existe) {
            // Validar que el correo sea único
            if ($por_signin) {
                Utils::showAlert("El correo ya está registrado.", "danger", "signin.php");
                return false;
            }

            // 2) Verificar contraseña
            $sql = "SELECT u.id, u.nombre, u.email, u.password_hash, r.nombre AS rol
            FROM usuarios u
            JOIN roles_usuarios ru ON u.id = ru.usuarios_id
            JOIN roles r ON ru.roles_id = r.id
            WHERE u.email = ?";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([$email]);
            $usuario = $stmt->fetch(\PDO::FETCH_ASSOC);
            if (password_verify($password, $usuario['password_hash'])) {
                $_SESSION['usuario'] = [
                    'id'     => $usuario['id'],
                    'nombre' => $usuario['nombre'],
                    'email'  => $usuario['email'],
                    'rol'    => $usuario['rol'],
                ];

                header("Location: /../index.php");
                return true;
            }

            Utils::showAlert("Credenciales incorrectas!", "danger", "login.php");
            return false;
        } elseif (!$por_signin && !$por_google && !$por_microsoft) {
            Utils::showAlert("El correo no está registrado.", "danger", "signin.php");
            return false;
        }

        // Registrar usuario

        // 1) Insertar usuario
        $sql = "INSERT INTO usuarios (nombre, email, telefono, password_hash) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nombre, $email, $telefono, password_hash($password, PASSWORD_DEFAULT)]);
        $usuario_id = $pdo->lastInsertId();

        // 2) Obtener el id del rol "default"
        $sql = "SELECT id FROM roles WHERE nombre = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['default']);
        $rol_id = $stmt->fetchColumn();

        // 3) Insertar relación usuario–rol
        $sql = "INSERT INTO roles_usuarios (roles_id, usuarios_id) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$rol_id, $usuario_id]);

        // 4) Recuperar datos del usuario
        $sql = "SELECT u.id, u.nombre, u.email, r.nombre AS rol
            FROM usuarios u
            JOIN roles_usuarios ru ON u.id = ru.usuarios_id
            JOIN roles r ON ru.roles_id = r.id
            WHERE u.id = ?
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$usuario_id]);
        $_SESSION['usuario'] = $stmt->fetch(PDO::FETCH_ASSOC);

        // 6) Limpiar sesiones
        unset($_SESSION['google_user'], $_SESSION['microsoft_user']);
        header("Location: /../index.php");
        return true;
    }

    public function handle(Template $template, $pdo)
    {
        global $google_client;

        if (self::validate_sesion($pdo)) {
            exit;
        }

        $template->apply([
            'login_button' => (isset($_SESSION['access_token'])) ? "" : $google_client->createAuthUrl(),
        ]);
    }
}

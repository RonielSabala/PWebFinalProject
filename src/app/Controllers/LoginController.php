<?php

namespace App\Controllers;

use App\Core\Template;
use PDO;


class LoginController
{
    public function handle(Template $template, $pdo)
    {
        global $google_client;

        // Tipos de registro
        $es_manual = $_SERVER['REQUEST_METHOD'] === 'POST';
        $es_google = isset($_SESSION['google_user']);
        $es_microsoft = isset($_SESSION['microsoft_user']);

        // Validar login
        if ($es_manual || $es_google || $es_microsoft) {
            // Registro manual
            if ($es_manual) {
                $nombre = $_POST['nombre'];
                $email = $_POST['email'];
                $telefono = $_POST['telefono'];
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

                // Registro con Google
            } elseif ($es_google) {
                $email = $_SESSION['google_user']['email'];
                $nombre = $_SESSION['google_user']['first_name'] . ' ' . $_SESSION['google_user']['last_name'];
                $telefono = '0000000000';
                $password = password_hash("oauth123", PASSWORD_DEFAULT);

                // Registro con Microsoft
            } else {
                $email = $_SESSION['microsoft_user']['email'];
                $nombre = $_SESSION['microsoft_user']['name'];
                $telefono = '0000000000';
                $password = password_hash("oauth123", PASSWORD_DEFAULT);
            }

            // 1) Verificar si ya existe el usuario
            $sql = "SELECT u.id, u.nombre, u.email, r.nombre AS rol
                FROM usuarios u
                JOIN roles_usuarios ru ON u.id = ru.usuarios_id
                JOIN roles r ON ru.roles_id = r.id
                WHERE u.email = ?
            ";

            $verificar = $pdo->prepare($sql);
            $verificar->execute([$email]);
            $usuarioExistente = $verificar->fetch(PDO::FETCH_ASSOC);
            if ($usuarioExistente) {
                $_SESSION['usuario'] = $usuarioExistente;

                header("Location: /../index.php");
                exit;
            }

            // 2) Registrar nuevo usuario
            $sql = "INSERT INTO usuarios (nombre, email, telefono, contraseña) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nombre, $email, $telefono, $password]);
            $usuario_id = $pdo->lastInsertId();

            // 3) Obtener el rol "default
            $sql = "SELECT id FROM roles WHERE nombre = ?";
            $rolStmt = $pdo->prepare($sql);
            $rolStmt->execute(['default']);
            $rol_id = $rolStmt->fetchColumn();

            // 4) Insertar relación usuario–rol
            $sql = "INSERT INTO roles_usuarios (roles_id, usuarios_id) VALUES (?, ?)";
            $relacion = $pdo->prepare($sql);
            $relacion->execute([$rol_id, $usuario_id]);

            // 5) Recuperar datos completos del usuario
            $sql = "SELECT u.id, u.nombre, u.email, r.nombre AS rol
                FROM usuarios u
                JOIN roles_usuarios ru ON u.id = ru.usuarios_id
                JOIN roles r ON ru.roles_id = r.id
                WHERE u.id = ?
            ";

            $final = $pdo->prepare($sql);
            $final->execute([$usuario_id]);
            $_SESSION['usuario'] = $final->fetch(PDO::FETCH_ASSOC);

            // 6) Limpiar sesiones de OAuth y redirigir
            unset($_SESSION['google_user'], $_SESSION['microsoft_user']);
            header("Location: /../index.php");
            exit;
        }

        $template->apply([
            'login_button' => (isset($_SESSION['access_token'])) ? "" : $google_client->createAuthUrl(),
        ]);
    }
}

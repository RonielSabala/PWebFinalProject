<?php

namespace App\Controllers;

use App\Core\Template;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class PasswordController
{
    public function handle(Template $template, $pdo)
    {
        session_start();
        require_once 'config/db.php';

        $accion = $_POST['accion'] ?? '';

        switch ($accion) {
            case 'enviar_codigo':
                $email = $_POST['email'];
                $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows === 1) {
                    $codigo = rand(100000, 999999);
                    $_SESSION['reset_codigo'] = $codigo;
                    $_SESSION['reset_email'] = $email;
                    $_SESSION['reset_expira'] = time() + 300;

                    $mail = new PHPMailer(true);
                    try {
                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com';
                        $mail->SMTPAuth = true;
                        $mail->Username = 'abelrobles0409@gmail.com';
                        $mail->Password = 'zyns tmxz tbdj xhra';
                        $mail->SMTPSecure = 'tls';
                        $mail->Port = 587;

                        $mail->setFrom('abelrobles0409@gmail.com', 'Incidencias App');
                        $mail->addAddress($email);
                        $mail->isHTML(true);
                        $mail->Subject = 'Codigo para restablecer contraseña';
                        $mail->Body = "Tu código es: <b>$codigo</b>. Válido por 5 minutos.";
                        $mail->send();

                        $_SESSION['success'] = 'Código enviado al correo.';
                        header("Location: reset_password.php");
                        exit;
                    } catch (Exception $e) {
                        $_SESSION['error'] = "Error al enviar el correo: {$mail->ErrorInfo}";
                        header("Location: forgot_password.php");
                        exit;
                    }
                } else {
                    $_SESSION['error'] = "El correo no está registrado.";
                    header("Location: forgot_password.php");
                    exit;
                }

            case 'validar_codigo':
                $codigo = trim($_POST['codigo']);
                if (!isset($_SESSION['reset_codigo']) || time() > $_SESSION['reset_expira']) {
                    $_SESSION['error'] = "Código expirado. Vuelve a solicitarlo.";
                    header("Location: forgot_password.php");
                    exit;
                }
                if ($codigo == $_SESSION['reset_codigo']) {
                    $_SESSION['codigo_valido'] = true;
                    header("Location: reset_password.php");
                    exit;
                } else {
                    $_SESSION['error'] = "Código incorrecto.";
                    header("Location: reset_password.php");
                    exit;
                }

            case 'guardar_contrasena':
                if (!isset($_SESSION['codigo_valido']) || $_SESSION['codigo_valido'] !== true) {
                    $_SESSION['error'] = "Acceso no autorizado.";
                    header("Location: forgot_password.php");
                    exit;
                }

                $password = $_POST['password'] ?? '';
                $confirm = $_POST['password_confirm'] ?? '';
                if ($password !== $confirm) {
                    $_SESSION['error'] = "Las contraseñas no coinciden.";
                    header("Location: reset_password.php");
                    exit;
                }
                if (strlen($password) < 6) {
                    $_SESSION['error'] = "Mínimo 6 caracteres.";
                    header("Location: reset_password.php");
                    exit;
                }

                $hashed = password_hash($password, PASSWORD_DEFAULT);
                $email = $_SESSION['reset_email'];
                $stmt = $conn->prepare("UPDATE usuarios SET contraseña = ? WHERE email = ?");
                $stmt->bind_param("ss", $hashed, $email);
                if ($stmt->execute()) {
                    unset($_SESSION['reset_codigo'], $_SESSION['reset_expira'], $_SESSION['reset_email'], $_SESSION['codigo_valido']);
                    $_SESSION['success'] = "Contraseña actualizada. Ya puedes iniciar sesión.";
                    header("Location: index.php");
                    exit;
                } else {
                    $_SESSION['error'] = "Error al guardar contraseña.";
                    header("Location: reset_password.php");
                    exit;
                }

            default:
                header("Location: forgot_password.php");
                exit;
        }
    }
}

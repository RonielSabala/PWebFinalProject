<?php

namespace App\Controllers\Login;

use App\Core\Template;
use App\Utils\UserUtils;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class ForgotPasswordController
{
    public function handle(Template $template, $pdo)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $template->apply();
            exit;
        }

        // Validar correo
        $email = $_POST['email'] ?? '';
        if (!UserUtils::exists($email)) {
            $_SESSION['error'] = "El correo no está registrado.";
            header("Location: forgot_password.php");
            exit;
        }

        // Datos para recuperar el correo
        $code = random_int(100000, 999999);
        $_SESSION['reset_password_email'] = $email;
        $_SESSION['reset_password_code'] = $code;
        $_SESSION['reset_password_expiration'] = time() + 300;

        // Enviar correo
        $mail = new PHPMailer(true);
        try {
            // Configuración de la conexión con la API
            $mail->isSMTP();
            $mail->Port       = 587;
            $mail->Host       = 'smtp.gmail.com';
            $mail->Username   = 'abelrobles0409@gmail.com';
            $mail->Password   = 'zyns tmxz tbdj xhra';
            $mail->SMTPSecure = 'tls';
            $mail->SMTPAuth   = true;

            // Datos del correo
            $mail->setFrom('abelrobles0409@gmail.com', 'IncidenciasRD');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Code to reset your password';
            $mail->Body    = "Your code is: <b>{$code}</b>. Valid for 5 minutes.";

            // Enviar código de recuperación y redirigir            
            $mail->send();
            header("Location: reset_password.php");
        } catch (Exception $e) {
            $_SESSION['error'] = "Error al enviar el correo: " . $mail->ErrorInfo;
            header("Location: forgot_password.php");
        }
    }
}

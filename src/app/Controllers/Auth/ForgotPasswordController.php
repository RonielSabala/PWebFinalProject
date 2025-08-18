<?php

namespace App\Controllers\Auth;

use App\Core\Template;
use App\Utils\GeneralUtils;
use App\Utils\Entities\UserUtils;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class ForgotPasswordController
{
    // Expiration time in seconds
    private static $code_expiration_time = 300;

    public function handle(Template $template)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $template->apply();
            exit;
        }

        // Validar correo
        $email = $_POST['email'] ?? '';
        if (!UserUtils::exists($email)) {
            $template->apply();
            GeneralUtils::showAlert('El correo proporcionado no está registrado.', showReturn: false);
            exit;
        }

        // Datos para recuperar el correo
        $reset_password_code = random_int(100000, 999999);
        $_SESSION['reset_password_email'] = $email;
        $_SESSION['reset_password_code'] = $reset_password_code;
        $_SESSION['reset_password_code_expiration_time'] = time() + self::$code_expiration_time;

        // Enviar correo
        $mail = new PHPMailer(true);
        try {
            // Configuración de la conexión con la API
            $mail_user = $_ENV['MAIL_USER'];
            $mail_pass = $_ENV['MAIL_PASS'];
            $mail->isSMTP();
            $mail->Port = 587;
            $mail->Host = 'smtp.gmail.com';
            $mail->Username = $mail_user;
            $mail->Password = $mail_pass;
            $mail->SMTPSecure = 'tls';
            $mail->SMTPAuth = true;

            // Datos del correo
            $mail->setFrom($mail_user, 'Incidencias RD');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Code to reset your password';
            $mail->Body = "Your code is: <b>{$reset_password_code}</b>. Valid for " . intval(self::$code_expiration_time / 60) . ' minutes.';

            // Enviar código de recuperación y redirigir            
            $mail->send();
            header('Location: reset_password.php');
        } catch (Exception $e) {
            GeneralUtils::showAlert('Error al enviar el correo: ' . $mail->ErrorInfo, showReturn: false);
            $template->apply();
        }
    }
}

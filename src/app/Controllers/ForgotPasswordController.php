<?php

namespace App\Controllers;

use App\Core\Template;
use App\Helpers\Utils;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class ForgotPasswordController
{
    public function handle(Template $template, $pdo)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';

            // Preparar y ejecutar con PDO
            $sql = "SELECT id FROM usuarios WHERE email = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':email', $email, \PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() === 1) {
                // Generar código y guardarlo en sesión
                $codigo = random_int(100000, 999999);
                $_SESSION['reset_codigo']  = $codigo;
                $_SESSION['reset_email']   = $email;
                $_SESSION['reset_expira']  = time() + 300;

                // Envío de correo
                $mail = new PHPMailer(true);
                try {
                    // Datos de conexión con la API del correo
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.gmail.com';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'abelrobles0409@gmail.com';
                    $mail->Password   = 'zyns tmxz tbdj xhra';
                    $mail->SMTPSecure = 'tls';
                    $mail->Port       = 587;

                    $mail->setFrom('abelrobles0409@gmail.com', 'IncidenciasRD');
                    $mail->addAddress($email);
                    $mail->isHTML(true);
                    $mail->Subject = 'Code to reset your password';
                    $mail->Body    = "Your code is: <b>{$codigo}</b>. Valid for 5 minutes.";
                    $mail->send();

                    header("Location: reset_password.php");
                    exit;
                } catch (Exception $e) {
                    $_SESSION['error'] = "Error al enviar el correo: " . $mail->ErrorInfo;
                    header("Location: forgot_password.php");
                    exit;
                }
            } else {
                $_SESSION['error'] = "El correo no está registrado.";
                header("Location: forgot_password.php");
                exit;
            }
        }

        $template->apply([
            'pdo' => $pdo,
            'showAlert' => [Utils::class, 'showAlert'],
        ]);
    }
}

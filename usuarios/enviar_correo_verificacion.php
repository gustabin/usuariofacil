<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

function enviarCorreoVerificacion($email, $token)
{
    $mail = new PHPMailer(true);

    $mail->SMTPDebug = 0;
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = 'true';
    $mail->Username   = 'stackcodelab@gmail.com';
    $mail->Password   = 'DEBES_COLOCAR_TU_PASSWORD';
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;

    $mail->setFrom('stackcodelab@gmail.com', 'Soporte Stackcodelab');
    $mail->addAddress($email);
    $mail->CharSet = 'UTF-8';

    //Contenido
    $mail->isHTML(true);
    $mail->Subject = 'Activar su cuenta';
    $mail->Body    = "Hola,\n\nPara activar su cuenta haga click en el enlace. " .
        "http://tudominio.com/usuariofacil/usuarios/activacion.php?token=$token\n\n" .
        "El equipo de Usuariofacil.";

    try {
        // Envío del correo de verificación
        $mail->send();
        echo 'El correo electrónico de verificación ha sido enviado.<br><br>';
        echo "Por favor, verifica tu dirección de correo electrónico antes de iniciar sesión.";
    } catch (Exception $e) {
        echo "Error al enviar el correo electrónico de verificación: {$mail->ErrorInfo}";
    }
}

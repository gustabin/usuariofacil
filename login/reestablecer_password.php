<?php
//Importar clases PHPMailer al espacio de nombres global
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

// Incluir el archivo de configuración
require '../tools/config.php';

// Conexión a la base de datos
$conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Variable de entrada (validación básica)
$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

// Array para la respuesta JSON
$response = array();

try {
    // Validar la dirección de correo electrónico
    if (!$email) {
        throw new Exception('Dirección de correo electrónico no válida.');
    }

    // Generar un token único y seguro para el restablecimiento de contraseña
    $token = password_hash(bin2hex(random_bytes(32)), PASSWORD_DEFAULT);

    // Almacenar el token y la fecha de solicitud en la base de datos
    $query = "UPDATE Usuarios SET TokenRecuperacion = ?, FechaRecuperacion = NOW() WHERE Email = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param('ss', $token, $email);
    $stmt->execute();

    // Verificar si la actualización fue exitosa
    if ($stmt->affected_rows > 0) {
        // La actualización fue exitosa, continuar con el envío del correo electrónico
        $mail = new PHPMailer(true);

        // Configuración del servidor SMTP
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host       = getenv('SMTP_HOST');
        $mail->SMTPAuth   = 'true';
        $mail->Username   = getenv('SMTP_USERNAME');
        $mail->Password   = getenv('SMTP_PASSWORD');
        $mail->SMTPSecure = 'ssl';
        $mail->Port       = getenv('SMTP_PORT');

        $mail->setFrom('stackcodelab@gmail.com', 'Soporte Stackcodelab');
        $mail->addAddress($email);
        $mail->CharSet = 'UTF-8';

        // Contenido del correo electrónico
        $mail->isHTML(true);
        $mail->Subject = 'Restablecimiento de Contraseña';
        $mail->Body    = "Hola,\n\nHemos recibido una solicitud para restablecer tu contraseña. " .
            "Haz clic en el siguiente enlace para restablecer tu contraseña:\n\n" .
            "http://tudominio.com/restablecer.php?token=$token\n\n" .
            "Si no solicitaste este restablecimiento, puedes ignorar este correo.";

        // Envío del correo electrónico
        $mailSent = $mail->send();

        // Verificar si el correo electrónico se envió correctamente
        if ($mailSent) {
            $response['status'] = 'exito';
            $response['message'] = 'El correo electrónico ha sido enviado.';
        } else {
            throw new Exception('Error al enviar el correo electrónico:' . $mail->ErrorInfo);
        }
    } else {
        throw new Exception('Error: No se pudo actualizar la base de datos.');
    }
} catch (Exception $e) {
    // Manejar la excepción y proporcionar un mensaje de error personalizado
    $response['status'] = 'error';
    $response['message'] = 'Error al restablecer la contraseña: ' . $e->getMessage();
} finally {
    // Cerrar la conexión
    if (isset($stmt)) {
        $stmt->close();
    }
    if (isset($conexion)) {
        $conexion->close();
    }
}

// Devolver la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($response);

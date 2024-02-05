<?php
//Importar clases PHPMailer al espacio de nombres global
//Estos deben estar en la parte superior de tu script, no dentro de una función
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

// Variable de entrada
$email = $_POST['email'];

// Generar un token único para el restablecimiento de contraseña
$token = bin2hex(random_bytes(32));

// Almacenar el token y la fecha de solicitud en la base de datos
$query = "UPDATE Usuarios SET TokenRecuperacion = ?, FechaRecuperacion = NOW() WHERE Email = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param('ss', $token, $email);
$stmt->execute();
// var_dump($token . " " . $email);

// Array para la respuesta JSON
$response = array();

if ($stmt->affected_rows > 0) {
    // La actualización fue exitosa, continuar con el envío del correo electrónico
    try {
        // Enviar un correo electrónico al usuario con el enlace de restablecimiento que incluye el token
        $mail = new PHPMailer(true);

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

        //Contenido
        $mail->isHTML(true);
        $mail->Subject = 'Restablecimiento de Contraseña';
        $mail->Body    = "Hola,\n\nHemos recibido una solicitud para restablecer tu contraseña. " .
            "Haz clic en el siguiente enlace para restablecer tu contraseña:\n\n" .
            "http://tudominio.com/restablecer.php?token=$token\n\n" .
            "Si no solicitaste este restablecimiento, puedes ignorar este correo.";
        $mailSent = $mail->send();

        // Verificar si el correo electrónico se envió correctamente
        if ($mailSent) {
            // echo 'El correo electrónico ha sido enviado.\n\n';
            // echo "http://tudominio.com/restablecer.php?token=$token\n\n";
            $response['status'] = 'exito';
            $response['message'] = 'El correo electrónico ha sido enviado.';
        } else {
            // Mostrar un mensaje de error si no se pudo enviar el correo electrónico
            // echo "Error al enviar el correo electrónico: {$mail->ErrorInfo}";
            $response['status'] = 'error';
            $response['message'] = 'Error al enviar el correo electrónico:' . $mail->ErrorInfo;
        }
    } catch (Exception $e) {
        // Capturar excepciones de PHPMailer
        // echo "Error al enviar el correo electrónico: {$e->getMessage()}";
        $response['status'] = 'error';
        $response['message'] = 'Error al enviar el correo electrónico:' . $e->getMessage();
    }
} else {
    // La actualización no fue exitosa, mostrar un mensaje de error
    // echo 'Error: No se pudo actualizar la base de datos.';
    $response['status'] = 'error';
    $response['message'] = 'Error: No se pudo actualizar la base de datos.';
}

// Cerrar la conexión
$stmt->close();
$conexion->close();

// Devolver la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($response);

<?php
// Incluir el archivo de configuración
require '../tools/config.php';
require('../mail/index.php'); // Requerir el archivo de envío de correo

// Generar un número aleatorio para el código
$numeroAleatorio = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);

$reply = "gustabin@yahoo.com"; // Dirección de correo electrónico para respuestas

// Conexión a la base de datos
$conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Array para la respuesta JSON
$response = array();

try {
    // Validar la dirección de correo electrónico
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    if (!$email) {
        throw new Exception('Dirección de correo electrónico no válida.');
    }

    // Generar un token único y seguro para el restablecimiento de contraseña
    $token = password_hash(bin2hex(random_bytes(32)), PASSWORD_DEFAULT);

    // Almacenar el token y la fecha de solicitud en la base de datos
    $query = "UPDATE usuarios SET TokenRecuperacion = ?, FechaRecuperacion = NOW() WHERE Email = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param('ss', $token, $email);
    $stmt->execute();

    // Verificar si la actualización fue exitosa
    if ($stmt->affected_rows > 0) {
        // Enviar email al administrador
        $subjectAdmin = "Solicitud de cambio de contraseña - Cod: $numeroAleatorio";
        $bodyAdmin = "<h2>Hola, se ha solicitado un restablecimiento de contraseña en el sistema.</h2>
            <p>Detalles:</p>
            <ul>
                <li>Email: $email</li>
                <li>Token: $token</li>
            </ul>
            <p>Puede procesar esta solicitud <a href='https://stackcodelab.com/usuariofacil/login/reset_password.php?token=$token'>aquí</a>.</p>
            <br><br>
            <br>
            El equipo de usuariofacil.<br>
            <img src=http://www.gustabin.com/img/logoEmpresa.png height=50px width=50px />
            <a href=https://www.facebook.com/gustabin2.0>
            <img src=http://www.gustabin.com/img/logoFacebook.jpg alt=Logo Facebook height=50px width=50px></a>
            <h5>Desarrollado por Gustabin<br>
            Copyright © 2024. Todos los derechos reservados. Version 1.0.0 <br></h5>
            ";
        enviarEmail("gustabin@yahoo.com", $subjectAdmin, $bodyAdmin, $reply);

        // Enviar email al usuario
        $subjectUser = "Recuperación de contraseña - Cod: $numeroAleatorio";
        $bodyUser = "<h2>Recuperación de contraseña</h2>
            <p>Hemos recibido su solicitud para restablecer la contraseña de su cuenta.</p>
            <p>Puede restablecer su contraseña <a href='https://stackcodelab.com/usuariofacil/login/reset_password.php?token=$token'>aquí</a>.</p>
            Gracias por confiar en nosotros.
            <br>
            El equipo de usuariofacil.<br>
            <img src=http://www.gustabin.com/img/logoEmpresa.png height=50px width=50px />
            <a href=https://www.facebook.com/gustabin2.0>
            <img src=http://www.gustabin.com/img/logoFacebook.jpg alt=Logo Facebook height=50px width=50px></a>
            <h5>Desarrollado por Gustabin<br>
            Copyright © 2024. Todos los derechos reservados. Version 1.0.0 <br></h5>
            ";

        enviarEmail($email, $subjectUser, $bodyUser, $reply);

        // Preparar la respuesta exitosa
        $response['status'] = 'exito';
        $response['message'] = '📧¡Correo de recuperación enviado! Por favor, revisa tu bandeja de entrada y sigue las instrucciones para restablecer tu contraseña. Si no recibes el correo en unos minutos, revisa tu carpeta de correo no deseado o spam.';
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

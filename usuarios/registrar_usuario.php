<?php
// Conexión a la base de datos (usando MySQLi)
$conexion = new mysqli('localhost', 'root', '', 'usuariofacil');

// Variables de entrada
$email = $_POST['email'];
// $email = "stackcodelab@gmail.com";

$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
// $password = password_hash("1234567890", PASSWORD_DEFAULT);

// Array para la respuesta JSON
$response = array();

try {
    // Consulta preparada para insertar un nuevo usuario
    $query = "INSERT INTO Usuarios (Email, PasswordHash, TokenRecuperacion) VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($query);

    if (!$stmt) {
        throw new Exception('Error en la preparación de la consulta: ' . $conexion->error);
    }
    // Generar un token único para la verificación de correo electrónico
    $token = bin2hex(random_bytes(32));

    $stmt->bind_param('sss', $email, $password, $token);
    $stmt->execute();

    // Verificar si la operación fue exitosa
    if ($stmt->affected_rows > 0) {
        // Éxito al insertar el usuario

        // Envío del correo de verificación
        require 'enviar_correo_verificacion.php';
        enviarCorreoVerificacion($email, $token);

        $response['status'] = 'exito';
        $response['message'] = 'Usuario registrado correctamente';
    } else {
        // Error al insertar el usuario
        throw new Exception('Error al registrar el usuario: No se realizaron cambios.');
    }
} catch (Exception $e) {
    // Manejar la excepción y proporcionar un mensaje de error personalizado
    $response['status'] = 'error';
    $response['message'] = 'Error al registrar el usuario: ' . $e->getMessage();
}

// Cerrar la conexión
$stmt->close();
$conexion->close();

// Devolver la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($response);

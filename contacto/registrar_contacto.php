<?php
// Incluir el archivo de configuración
require '../tools/config.php';

// Conexión a la base de datos (usando MySQLi)
$conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Variables de entrada
$nombre = $_POST['nombre'];
$email = $_POST['email'];
$telefono = $_POST['telefono'];
$mensaje = $_POST['mensaje'];

// Array para la respuesta JSON
$response = array();

try {
    // Consulta preparada para insertar un nuevo contacto
    $query = "INSERT INTO Contactos (Nombre, Email, Telefono, Mensaje, Fecha) VALUES (?, ?, ?, ?, NOW())";
    $stmt = $conexion->prepare($query);

    if (!$stmt) {
        throw new Exception('Error en la preparación de la consulta: ' . $conexion->error);
    }

    $stmt->bind_param('ssss', $nombre, $email, $telefono, $mensaje);
    $stmt->execute();

    // Verificar si la operación fue exitosa
    if ($stmt->affected_rows > 0) {
        // Éxito al insertar el contacto
        $response['status'] = 'exito';
        $response['message'] = 'Contacto registrado correctamente';
    } else {
        // Error al insertar el contacto
        throw new Exception('Error al registrar el contacto: No se realizaron cambios.');
    }
} catch (Exception $e) {
    // Manejar la excepción y proporcionar un mensaje de error personalizado
    $response['status'] = 'error';
    $response['message'] = 'Error al registrar el contacto: ' . $e->getMessage();
}

// Cerrar la conexión
$stmt->close();
$conexion->close();

// Devolver la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($response);

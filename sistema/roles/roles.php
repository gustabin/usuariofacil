<?php
// Incluir el archivo de configuración
require '../../tools/config.php';
// Variables de entrada
session_start();
// Verificar si la sesión está iniciada y si la clave 'usuarioID' está definida
if (session_status() == PHP_SESSION_NONE || !isset($_SESSION['usuarioID'])) {
    $response['status'] = 'error';
    $response['message'] = 'La sesión no está iniciada o no se ha proporcionado el usuarioID';
    echo json_encode($response);
    exit;
}

// Array para la respuesta JSON
$response = array();

try {
    // Conexión a la base de datos (usando MySQLi)
    $conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    // Verificar errores de conexión
    if ($conexion->connect_error) {
        throw new Exception("Error de conexión: " . $conexion->connect_error);
    }

    // Consulta SQL para obtener los datos de usuarios con sus roles
    $query = "SELECT UsuarioID, Email, rol FROM usuarios";

    // Ejecutar la consulta
    $result = $conexion->query($query);

    // Verificar errores en la consulta
    if (!$result) {
        throw new Exception("Error en la consulta: " . $conexion->error);
    }

    $usuarios = [];

    // Obtener datos de usuarios y sus roles
    while ($row = $result->fetch_assoc()) {
        // Añadir los datos al array de usuarios
        $usuarios[] = [
            'UsuarioID' => $row['UsuarioID'],
            'Email' => $row['Email'],
            'rol' => $row['rol']
        ];
    }

    // Enviar datos en formato JSON para DataTable
    echo json_encode(['data' => $usuarios]);
} catch (Exception $e) {
    // Capturar y manejar cualquier excepción
    $response['error'] = $e->getMessage();
    echo json_encode($response);
} finally {
    // Cerrar la conexión de todas formas
    if (isset($conexion)) {
        $conexion->close();
    }
}

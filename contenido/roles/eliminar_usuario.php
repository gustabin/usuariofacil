<?php
// Incluir el archivo de configuración
require '../../tools/config.php';

// Conexión a la base de datos (usando MySQLi)
$conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Variables de entrada
$usuarioID = $_POST['usuarioID'];

// Array para la respuesta JSON
$response = array();

try {
    // Consulta preparada para eliminar un usuario
    $query = "DELETE FROM Usuarios WHERE UsuarioID = ?";
    $stmt = $conexion->prepare($query);

    if (!$stmt) {
        throw new Exception('Error en la preparación de la consulta: ' . $conexion->error);
    }

    $stmt->bind_param('i', $usuarioID);
    $stmt->execute();

    // Verificar si la operación fue exitosa
    if ($stmt->affected_rows > 0) {
        // Éxito al eliminar el usuario
        $response['status'] = 'exito';
        $response['message'] = 'Usuario eliminado correctamente';
    } else {
        // Error al eliminar el usuario
        throw new Exception('Error al eliminar el usuario: No se realizaron cambios.');
    }
} catch (Exception $e) {
    // Manejar la excepción y proporcionar un mensaje de error personalizado
    $response['status'] = 'error';
    $response['message'] = 'Error al eliminar el usuario: ' . $e->getMessage();
}

// Cerrar la conexión
$stmt->close();
$conexion->close();

// Devolver la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($response);

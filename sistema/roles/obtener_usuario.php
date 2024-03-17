<?php
// Incluir el archivo de configuración
require '../../tools/config.php';

// Array para la respuesta JSON
$response = array();

try {
    // Conexión a la base de datos (usando MySQLi)
    $conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    // Verificar errores de conexión
    if ($conexion->connect_error) {
        throw new Exception("Error de conexión: " . $conexion->connect_error);
    }

    // Verificar si se proporciona un ID en la solicitud GET
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        // Obtener el ID del usuario desde la solicitud y validar que sea un número entero
        $idUsuario = intval($_GET['id']);

        // Consulta preparada para obtener datos específicos del usuario por su ID
        $query = "SELECT * FROM usuarios WHERE UsuarioID = ?";
        $stmt = $conexion->prepare($query);

        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $conexion->error);
        }

        $stmt->bind_param('i', $idUsuario);
        $stmt->execute();

        // Obtener el resultado de la consulta
        $result = $stmt->get_result();

        // Verificar si se encontró algún usuario
        if ($result->num_rows > 0) {
            // Obtener datos del usuario específico
            $usuario = $result->fetch_assoc();

            // Enviar datos en formato JSON
            echo json_encode($usuario);
        } else {
            // Si no se encontró ningún usuario con el ID proporcionado, devolver un mensaje de error
            throw new Exception("No se encontró ningún usuario con el ID proporcionado.");
        }

        // Cerrar la consulta preparada
        $stmt->close();
    } else {
        // Si no se proporciona un ID de usuario válido, devolver un mensaje de error
        throw new Exception("No se proporcionó un ID de usuario válido.");
    }
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

<?php
// Incluir el archivo de configuración
require '../../tools/config.php';

// Array para la respuesta JSON
$response = array();

try {
    // Verificar si se proporcionó un usuarioID y si es un número entero válido
    if (isset($_POST['usuarioID']) && is_numeric($_POST['usuarioID'])) {
        // Obtener el usuarioID y validar que sea un número entero
        $usuarioID = intval($_POST['usuarioID']);

        // Conexión a la base de datos (usando MySQLi)
        $conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        // Consulta preparada para eliminar un usuario
        $query = "DELETE FROM usuarios WHERE UsuarioID = ?";
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

        // Cerrar la conexión
        $stmt->close();
        $conexion->close();
    } else {
        // Manejar el caso en que el usuarioID no esté definido o no sea un número entero válido
        throw new Exception('El usuarioID proporcionado no es válido');
    }
} catch (Exception $e) {
    // Manejar la excepción y proporcionar un mensaje de error personalizado
    $response['status'] = 'error';
    $response['message'] = 'Error al eliminar el usuario: ' . $e->getMessage();
}

// Devolver la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($response);

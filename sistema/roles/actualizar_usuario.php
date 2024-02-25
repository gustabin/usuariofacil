<?php
// Incluir el archivo de configuración
require '../../tools/config.php';

// Conexión a la base de datos (usando MySQLi)
$conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if (isset($_POST['usuarioID'], $_POST['email'], $_POST['verificado'], $_POST['rol'])) {
    $usuarioID = $_POST['usuarioID'];
    $email = $_POST['email'];
    $verificado = $_POST['verificado'];
    $rol = $_POST['rol'];
    // Resto del código...
} else {
    // Manejar el caso en que algunas variables no estén definidas
    $response['status'] = 'error';
    $response['message'] = 'Faltan datos requeridos';
    echo json_encode($response);
    exit;
}

// Array para la respuesta JSON
$response = array();

try {
    // Consulta preparada para actualizar un usuario
    $query = "UPDATE Usuarios SET Email = ?, Verificado = ?, Rol = ? WHERE UsuarioID = ?";
    $stmt = $conexion->prepare($query);

    if (!$stmt) {
        throw new Exception('Error en la preparación de la consulta: ' . $conexion->error);
    }

    $stmt->bind_param('siii', $email, $verificado, $rol, $usuarioID);
    $stmt->execute();

    // Verificar si la operación fue exitosa
    if ($stmt->affected_rows > 0) {
        // Éxito al actualizar el usuario
        $response['status'] = 'exito';
        $response['message'] = 'Usuario actualizado correctamente';
    } else {
        // Error al actualizar el usuario
        throw new Exception('Error al actualizar el usuario: No se realizaron cambios.');
    }
} catch (Exception $e) {
    // Manejar la excepción y proporcionar un mensaje de error personalizado
    $response['status'] = 'error';
    $response['message'] = 'Error al actualizar el usuario: ' . $e->getMessage();
    // También podrías registrar el error para propósitos de depuración
    error_log('Error en actualizar_usuario.php: ' . $e->getMessage());
}

// Cerrar la conexión
$stmt->close();
$conexion->close();

// Devolver la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($response);

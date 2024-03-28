<?php
// Incluir el archivo de configuración
require '../../tools/config.php';

// Conexión a la base de datos (usando MySQLi)
$conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
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
    // Verificar si todas las variables necesarias están definidas
    if (isset($_POST['usuarioID'], $_POST['email'], $_POST['verificado'], $_POST['rol'])) {
        // Obtener y validar los datos del formulario
        $usuarioID = intval($_POST['usuarioID']);
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $verificado = intval($_POST['verificado']);
        $rol = intval($_POST['rol']);

        // Verificar la validez del correo electrónico
        if (!$email) {
            throw new Exception('El correo electrónico proporcionado no es válido');
        }

        // Consulta preparada para actualizar un usuario
        $query = "UPDATE usuarios SET Email = ?, Verificado = ?, Rol = ? WHERE UsuarioID = ?";
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

        // Cerrar la consulta preparada
        $stmt->close();
    } else {
        // Manejar el caso en que algunas variables no estén definidas
        throw new Exception('Faltan datos requeridos');
    }
} catch (Exception $e) {
    // Manejar la excepción y proporcionar un mensaje de error personalizado
    $response['status'] = 'error';
    $response['message'] = 'Error al actualizar el usuario: ' . $e->getMessage();
    // También podrías registrar el error para propósitos de depuración
    error_log('Error en actualizar_usuario.php: ' . $e->getMessage());
}

// Cerrar la conexión
$conexion->close();

// Devolver la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($response);

<?php
// Incluir el archivo de configuración
require '../../tools/config.php';
// Conexión a la base de datos
$conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Variable de entrada
session_start();
$usuarioID = $_SESSION['usuarioID'];

$response = array();

try {
    // Validación de sesión
    if (!isset($_SESSION['usuarioID'])) {
        // Redirigir a la página de inicio de sesión
        header('Location: ../../login');
        exit();
    }

    // Consulta preparada para obtener el perfil de un usuario
    $query = "SELECT * FROM Perfiles WHERE UsuarioID = ?";
    $stmt = $conexion->prepare($query);

    if ($stmt) {
        // Vincular el parámetro
        $stmt->bind_param('i', $usuarioID);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $perfil = $result->fetch_assoc();
            $nombre = $perfil['Nombre'];
            $apellido = $perfil['Apellido'];
            $avatarURL = $perfil['AvatarURL'];

            // Datos del perfil en formato JSON
            $response['status'] = 'exito';
            $response['nombre'] = $nombre;
            $response['apellido'] = $apellido;
            $response['avatarURL'] = $avatarURL;
        } else {
            // No se encontraron resultados
            $response['status'] = 'error';
            $response['message'] = 'No se encontraron resultados para el usuario con ID ' . $usuarioID;
        }

        // Cerrar el statement
        $stmt->close();
    } else {
        throw new Exception("Error al preparar la consulta");
    }
} catch (Exception $e) {
    // Manejar errores y loggear información detallada
    error_log('Error en perfil_usuario.php: ' . $e->getMessage());
    $response['status'] = 'error';
    $response['message'] = 'Error al procesar la solicitud. Por favor, inténtalo de nuevo más tarde.';
}

// Cerrar la conexión
$conexion->close();

// Devolver la respuesta en formato JSON
echo json_encode($response);

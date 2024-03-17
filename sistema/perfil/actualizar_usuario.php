<?php
// Incluir el archivo de configuración
require '../../tools/config.php';

// Conexión a la base de datos
$conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Variables de entrada
session_start();
$usuarioID = $_SESSION['usuarioID'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];

$response = array();

// Inicializar la variable $response['avatarURL']
$response['avatarURL'] = null;

// Verificar si se ha proporcionado un archivo
try {
    if (isset($_FILES['avatarURL']) && $_FILES['avatarURL']['error'] === UPLOAD_ERR_OK) {
        $nombreArchivo = $usuarioID . '_' . $_FILES['avatarURL']['name'];
        $rutaTemporal = $_FILES['avatarURL']['tmp_name'];

        // Verificar y mover el archivo a la ubicación deseada en el servidor
        $directorioAlmacenamiento = "imagen/";
        $rutaAlmacenamiento = $directorioAlmacenamiento . $nombreArchivo;

        if (!file_exists($directorioAlmacenamiento) && !is_dir($directorioAlmacenamiento)) {
            mkdir($directorioAlmacenamiento, 0777, true);
        }

        // Mover el archivo
        if (move_uploaded_file($rutaTemporal, $rutaAlmacenamiento)) {
            // Actualizar la URL del avatar en la base de datos
            $updateQuery = "UPDATE perfiles SET AvatarURL = ? WHERE UsuarioID = ?";
            $updateStmt = $conexion->prepare($updateQuery);

            if (!$updateStmt) {
                throw new Exception('Error en la preparación de la consulta de actualización de avatar: ' . $conexion->error);
            }

            $updateStmt->bind_param('si', $rutaAlmacenamiento, $usuarioID);
            $updateStmt->execute();

            // Verificar si la actualización del avatar fue exitosa
            if ($updateStmt->affected_rows > 0) {
                $response['avatarURL'] = $rutaAlmacenamiento;
            } else {
                throw new Exception('Error al actualizar el avatar para el ID ' . $usuarioID);
            }

            // Cerrar la conexión para liberar recursos
            $updateStmt->close();
        }
    }
} catch (Exception $e) {
    $response['status'] = 'error';
    $response['message'] = $e->getMessage();
    echo json_encode($response);
    exit;
}

// Consulta preparada para actualizar el perfil de un usuario
$query = "UPDATE perfiles SET Nombre = ?, Apellido = ? WHERE UsuarioID = ?";
$stmt = $conexion->prepare($query);

// Verificar si hay algún error en la preparación de la consulta
if (!$stmt) {
    $response['status'] = 'error';
    $response['message'] = 'Error en la preparación de la consulta: ' . $conexion->error;
} else {
    // Ejecutar la actualización del perfil
    $stmt->bind_param('ssi', $nombre, $apellido, $usuarioID);
    $stmt->execute();

    // Verificar si la operación fue exitosa
    if ($stmt->affected_rows > 0) {
        // Si se actualizó el perfil o no se proporcionó un archivo
        $response['status'] = 'exito';
        $response['nombre'] = $nombre;
        $response['apellido'] = $apellido;
        // Puedes agregar más información si es necesario
    }

    // Cerrar la conexión
    $stmt->close();
}

// Cerrar la conexión principal
$conexion->close();

// Mostrar la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($response);

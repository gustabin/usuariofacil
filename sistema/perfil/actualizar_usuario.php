<?php
// Conexión a la base de datos
$conexion = new mysqli('localhost', 'root', '', 'usuariofacil');

// Variables de entrada
session_start();
$usuarioID = $_SESSION['usuarioID'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];

$response = array();

// Inicializar la variable $response['avatarURL']
$response['avatarURL'] = null;

// Verificar si se ha proporcionado un archivo
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
        $updateQuery = "UPDATE Perfiles SET AvatarURL = ? WHERE UsuarioID = ?";
        $updateStmt = $conexion->prepare($updateQuery);
        $updateStmt->bind_param('si', $rutaAlmacenamiento, $usuarioID);
        $updateStmt->execute();

        // Verificar si la actualización del avatar fue exitosa
        if ($updateStmt->affected_rows > 0) {
            $response['avatarURL'] = $rutaAlmacenamiento;
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Error al actualizar el avatar para el ID ' . $usuarioID;
            echo json_encode($response);
            // exit;
        }
        // Cerrar la conexión para liberar recursos
        $updateStmt->close();
    }
}

// Consulta preparada para actualizar el perfil de un usuario
$query = "UPDATE Perfiles SET Nombre = ?, Apellido = ? WHERE UsuarioID = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param('ssi', $nombre, $apellido, $usuarioID);

// Verificar si hay algún error en la preparación de la consulta
if (!$stmt) {
    $response['status'] = 'error';
    $response['message'] = 'Error en la preparación de la consulta: ' . $conexion->error;
} else {
    // Ejecutar la actualización del perfil
    $stmt->execute();

    // Verificar si la operación fue exitosa
    if ($stmt) {
        // if ($stmt->affected_rows > 0) {
        // Si se actualizó el perfil o no se proporcionó un archivo
        $response['status'] = 'exito';
        $response['nombre'] = $nombre;
        $response['apellido'] = $apellido;
        // Puedes agregar más información si es necesario
    }
    // else {
    //     $response['status'] = 'error';
    //     $response['message'] = 'Error al actualizar el perfil para el ID ' . $usuarioID;
    // }

    // Cerrar la conexión
    $stmt->close();
}

// Cerrar la conexión principal
$conexion->close();

// Mostrar la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($response);

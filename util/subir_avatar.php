<?php
// Incluir el archivo de configuración
require '../tools/config.php';
// Conexión a la base de datos
$conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Variables de entrada
$nombreArchivo = 'logo.png';

// Obtener información sobre el archivo simulado
$rutaTemporal = 'imagen/' . $nombreArchivo;
$archivoSimulado = array(
    'name'     => $nombreArchivo,
    'type'     => mime_content_type($rutaTemporal),
    'tmp_name' => $rutaTemporal,
    'error'    => 0,  // Sin errores
    'size'     => filesize($rutaTemporal)
);

// Validar la existencia y formato del archivo
if (!file_exists($archivoSimulado['tmp_name']) || $archivoSimulado['error'] !== UPLOAD_ERR_OK) {
    // Manejar el error, por ejemplo, mostrar un mensaje o redirigir
    die("Error al subir el archivo.");
}

// Validar el tipo de archivo
$allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
if (!in_array($archivoSimulado['type'], $allowedTypes)) {
    // Manejar el error, por ejemplo, mostrar un mensaje o redirigir
    die("Tipo de archivo no permitido.");
}

// Configurar la carpeta de almacenamiento
$directorioAlmacenamiento = "imagen/";

// Generar un nombre de archivo único
$nombreArchivoUnico = uniqid() . '_' . $nombreArchivo;

// Construir la ruta de almacenamiento
$rutaAlmacenamiento = $directorioAlmacenamiento . $nombreArchivoUnico;

// Mover el archivo a la ubicación deseada en el servidor
if (move_uploaded_file($archivoSimulado['tmp_name'], $rutaAlmacenamiento)) {
    // Actualizar la URL del avatar en la base de datos
    $updateQuery = "UPDATE perfiles SET AvatarURL = ? WHERE UsuarioID = ?";
    $updateStmt = $conexion->prepare($updateQuery);
    $updateStmt->bind_param('si', $rutaAlmacenamiento, $usuarioID);
    $updateStmt->execute();

    if ($updateStmt->affected_rows > 0) {
        echo "Archivo subido y base de datos actualizada correctamente.";
    } else {
        echo "Error al actualizar la base de datos.";
    }

    // Cerrar la conexión
    $updateStmt->close();
} else {
    // Manejar el error, por ejemplo, mostrar un mensaje o redirigir
    echo "Error al mover el archivo.";
}

// Cerrar la conexión
$conexion->close();

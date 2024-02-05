<?php
// Incluir el archivo de configuración
require '../tools/config.php';
// Conexión a la base de datos
$conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Variables de entrada
$usuarioID = 1;
//    $avatar = $_FILES['avatar']; // Suponiendo que se ha enviado el archivo mediante un formulario

$nombreArchivo = 'logo.png';
$rutaTemporal = 'imagen/' . $nombreArchivo;

// Construir una estructura similar a la que se obtiene de $_FILES['avatar']
$archivoSimulado = array(
    'name'     => $nombreArchivo,
    'type'     => mime_content_type($rutaTemporal),
    'tmp_name' => $rutaTemporal,
    'error'    => 0,  // Sin errores
    'size'     => filesize($rutaTemporal)
);

// Usar la variable simulada en lugar de $_FILES['avatar']
$avatar = $archivoSimulado;

// Verificar y mover el archivo a la ubicación deseada en el servidor
// Generar una URL o ruta de almacenamiento y almacenarla en la base de datos
//    $rutaAlmacenamiento = "imagen/usuario/avatar" . $avatar['name'];
$directorioAlmacenamiento = "imagen/";
$rutaAlmacenamiento =  $directorioAlmacenamiento . "logoNuevoNombre.png";
// move_uploaded_file($avatar['tmp_name'], $rutaAlmacenamiento);
copy($avatar['tmp_name'], $rutaAlmacenamiento);

// Actualizar la URL del avatar en la base de datos
$updateQuery = "UPDATE Perfiles SET AvatarURL = ? WHERE UsuarioID = ?";
$updateStmt = $conexion->prepare($updateQuery);
$updateStmt->bind_param('si', $rutaAlmacenamiento, $usuarioID);
$updateStmt->execute();

// Cerrar la conexión
$updateStmt->close();
$conexion->close();

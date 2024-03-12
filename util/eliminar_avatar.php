<?php
// Incluir el archivo de configuración
require '../tools/config.php';

// Validar la entrada del usuario (ejemplo: verificar que $usuarioID sea un entero positivo)
$usuarioID = isset($_POST['usuarioID']) ? (int)$_POST['usuarioID'] : 0;

if ($usuarioID <= 0) {
    die('ID de usuario no válido.');
}

// Conexión a la base de datos
$conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

try {
    // Obtener la URL del avatar actual en la base de datos
    $selectQuery = "SELECT AvatarURL FROM Perfiles WHERE UsuarioID = ?";
    $selectStmt = $conexion->prepare($selectQuery);
    $selectStmt->bind_param('i', $usuarioID);
    $selectStmt->execute();
    $selectStmt->store_result();

    // Verificar si se obtuvieron resultados
    if ($selectStmt->num_rows > 0) {
        $selectStmt->bind_result($avatarURL);
        $selectStmt->fetch();

        // Verificar si el archivo existe antes de intentar eliminarlo
        if (file_exists($avatarURL) && is_writable($avatarURL)) {
            // Eliminar el archivo de la ubicación de almacenamiento
            unlink($avatarURL);

            // Actualizar la URL del avatar en la base de datos
            $updateQuery = "UPDATE Perfiles SET AvatarURL = NULL WHERE UsuarioID = ?";
            $updateStmt = $conexion->prepare($updateQuery);
            $updateStmt->bind_param('i', $usuarioID);
            $updateStmt->execute();

            // Verificar si la actualización fue exitosa
            if ($updateStmt->affected_rows > 0) {
                echo 'Avatar eliminado correctamente.';
            } else {
                echo 'Error al actualizar la base de datos.';
            }

            // Cerrar la conexión
            $updateStmt->close();
        } else {
            echo 'El archivo no existe o no se puede eliminar.';
        }
    } else {
        echo 'Usuario no encontrado.';
    }

    // Cerrar la conexión
    $selectStmt->close();
    $conexion->close();
} catch (Exception $e) {
    // Manejar excepciones y mostrar mensajes de error
    echo 'Error: ' . $e->getMessage();
    $conexion->close(); // Asegurar la desconexión en caso de excepción
}

<?php
// Iniciar la sesión
session_start();

// Incluir el archivo de configuración
require '../tools/config.php';
// Conexión a la base de datos
$conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Variables de entrada

// Leer variable de sesión
$token = $_SESSION['token'];
$nuevaContraseña = password_hash($_POST['nuevaContraseña'], PASSWORD_DEFAULT);
// $nuevaContraseña = password_hash("0987654321", PASSWORD_DEFAULT);

// Verificar la validez del token y la fecha de solicitud
$query = "SELECT UsuarioID FROM usuarios WHERE TokenRecuperacion = ? AND FechaRecuperacion > DATE_SUB(NOW(), INTERVAL 1 HOUR)";
$stmt = $conexion->prepare($query);
$stmt->bind_param('s', $token);
$stmt->execute();
$stmt->store_result();

// Si la consulta devuelve un resultado, el token es válido
if ($stmt->num_rows > 0) {
    // Validar la nueva contraseña
    if (!validarContraseña($nuevaContraseña)) {
        echo "La nueva contraseña no cumple con los requisitos de seguridad.";
    } else {
        // Actualizar la contraseña del usuario
        $stmt->bind_result($usuarioID);
        $stmt->fetch();

        $updateQuery = "UPDATE usuarios SET PasswordHash = ?, TokenRecuperacion = NULL, FechaRecuperacion = NULL WHERE UsuarioID = ?";
        $updateStmt = $conexion->prepare($updateQuery);
        $updateStmt->bind_param('si', $nuevaContraseña, $usuarioID);
        $updateStmt->execute();

        // Informar al usuario que la contraseña ha sido restablecida
        echo "La contraseña ha sido restablecida correctamente.";
    }
} else {
    // Informar al usuario que el token no es válido o ha expirado
    echo "El token no es válido o ha expirado.";
}

// Cerrar la conexión
$stmt->close();
$conexion->close();

// Función de validación de contraseña
function validarContraseña($contraseña)
{
    // Implementa tus criterios de seguridad aquí (longitud, caracteres especiales, etc.)
    return true;
}

<?php
// Iniciar la sesión
session_start();

// Conexión a la base de datos
$conexion = new mysqli('localhost', 'root', '', 'usuariofacil');

// Variables de entrada

// Leer variable de session
$token = $_SESSION['token'];
// $nuevaContraseña = password_hash($_POST['nuevaContraseña'], PASSWORD_DEFAULT);
$nuevaContraseña = password_hash("0987654321", PASSWORD_DEFAULT);

// Verificar la validez del token y la fecha de solicitud
$query = "SELECT UsuarioID FROM Usuarios WHERE TokenRecuperacion = ? AND FechaRecuperacion > DATE_SUB(NOW(), INTERVAL 1 HOUR)";
$stmt = $conexion->prepare($query);
$stmt->bind_param('s', $token);
$stmt->execute();
$stmt->store_result();

// Si la consulta devuelve un resultado, el token es válido
if ($stmt->num_rows > 0) {
    // Actualizar la contraseña del usuario
    $stmt->bind_result($usuarioID);
    $stmt->fetch();

    $updateQuery = "UPDATE Usuarios SET PasswordHash = ?, TokenRecuperacion = NULL, FechaRecuperacion = NULL WHERE UsuarioID = ?";
    $updateStmt = $conexion->prepare($updateQuery);
    $updateStmt->bind_param('si', $nuevaContraseña, $usuarioID);
    $updateStmt->execute();

    // Informar al usuario que la contraseña ha sido restablecida
    echo "la contraseña ha sido restablecida";
} else {
    // Informar al usuario que el token no es válido o ha expirado
    echo "el token no es válido o ha expirado";
}

// Cerrar la conexión
$stmt->close();
$conexion->close();

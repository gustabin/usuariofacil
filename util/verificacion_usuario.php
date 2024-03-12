<?php
// Incluir el archivo de configuración
require '../tools/config.php';
// Conexión a la base de datos
$conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Variable de entrada (debería provenir de una fuente segura, como una sesión)
$usuarioID = $_GET['usuarioID'] ?? 0;
$usuarioID = filter_var($usuarioID, FILTER_VALIDATE_INT);

// Validar que el ID del usuario sea un entero positivo
if ($usuarioID === false || $usuarioID <= 0) {
    // Manejar el error, por ejemplo, mostrar un mensaje o redirigir
    die("ID de usuario no válido.");
}

// Consulta preparada para marcar un usuario como verificado
$query = "UPDATE Usuarios SET Verificado = true WHERE UsuarioID = ?";
$stmt = $conexion->prepare($query);

if (!$stmt) {
    // Manejar el error, por ejemplo, mostrar un mensaje o redirigir
    die("Error en la preparación de la consulta: " . $conexion->error);
}

$stmt->bind_param('i', $usuarioID);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Usuario verificado correctamente.";
} else {
    echo "No se pudo verificar al usuario. El ID puede ser inválido.";
}

// Cerrar la conexión
$stmt->close();
$conexion->close();

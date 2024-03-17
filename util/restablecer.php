<?php
// Iniciar la sesión
session_start();
// Incluir el archivo de configuración
require '../tools/config.php';
// Conexión a la base de datos y configuración de la sesión
$conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Verificar si se proporcionó un token en la URL
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Consultar la base de datos para encontrar un usuario con el token proporcionado
    $query = "SELECT UsuarioID FROM usuarios WHERE TokenRecuperacion = ? AND FechaRecuperacion > DATE_SUB(NOW(), INTERVAL 1 HOUR)";
    // Ejecutar la consulta (asegúrate de tener una conexión a la base de datos establecida)
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->bind_result($usuarioID);
    $stmt->fetch();


    // Verificar si se encontró un usuario con el token válido
    if ($usuarioID) {
        if (true) { // En este punto, deberías haber verificado si se encontró un usuario válido en la base de datos
            // Presentar formulario para restablecer la contraseña
            $_SESSION['token'] = $token;
            echo "Formulario para restablecer la contraseña";
        } else {
            // Token no válido, mostrar mensaje de error o redirigir a una página de error
            echo "Token no válido. Por favor, verifica el enlace o realiza una nueva solicitud.";
        }
    }
    // Cerrar la conexión
    $stmt->close();
    $conexion->close();
} else {
    // No se proporcionó un token en la URL, mostrar mensaje de error o redirigir a una página de error
    echo "Token no proporcionado. Por favor, utiliza el enlace proporcionado en tu correo electrónico.";
}

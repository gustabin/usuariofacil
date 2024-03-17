<?php
// Incluir el archivo de configuración
require '../tools/config.php';

// Verificar si se ha proporcionado un token válido en la URL
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Conexión a la base de datos (usando MySQLi)
    $conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    // Verificar errores de conexión
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Consulta preparada para actualizar el campo Verificado a true
    $query = "UPDATE usuarios SET Verificado = 1 WHERE TokenRecuperacion = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param('s', $token);
    $stmt->execute();


    if ($stmt->affected_rows > 0) {
        // Mostrar un mensaje de éxito
        echo '<div id="success-message">Tu dirección de correo electrónico ha sido verificada correctamente.</div>';
        echo '<script>
                // Redirigir a login.php después de 3 segundos
                setTimeout(function(){
                    window.location.href = "./../login/";
                }, 3000);
              </script>';
        exit();
    } else {
        // Mostrar un mensaje de error genérico
        echo 'No se pudo verificar tu dirección de correo electrónico. Por favor, verifica si el enlace es válido o si ya ha sido utilizado.';
    }


    // Cerrar la conexión
    $stmt->close();
    $conexion->close();
} else {
    // En caso de que no se haya proporcionado un token válido en la URL
    echo 'Token no válido.';
    // Redirigir a una página de error
    header('Location: error.php');
    exit();
}

<?php
// Conexión a la base de datos
$conexion = new mysqli('localhost', 'root', '', 'usuariofacil');

// Verificar si se ha proporcionado un token en la URL
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Consulta preparada para actualizar el campo Verificado a true
    $query = "UPDATE Usuarios SET Verificado = true WHERE TokenRecuperacion = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param('s', $token);
    $stmt->execute();

    // Verificar si la actualización fue exitosa
    if ($stmt->affected_rows > 0) {
        echo 'Tu dirección de correo electrónico ha sido verificada correctamente.';

        // Redirigir a login.php
        header('Location: login.php');
        exit();
    } else {
        echo 'No se pudo verificar tu dirección de correo electrónico. El enlace puede ser inválido o ya se ha utilizado.';
    }

    // Cerrar la conexión
    $stmt->close();
    $conexion->close();
} else {
    // En caso de que no se haya proporcionado un token en la URL
    echo 'Token no válido.';
    header('Location: error.php');
    exit();
    // Puedes redirigir al usuario a una página de error o a otra página relevante.
}

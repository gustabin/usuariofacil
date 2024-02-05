<?php
// Incluir el archivo de configuración
require '../tools/config.php';

// Conexión a la base de datos
$conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Variables de entrada
$email = $_POST['email'];
$password = $_POST['password'];

// Array para la respuesta JSON
$response = array();

try {
    // Consulta preparada para obtener el hash de la contraseña del usuario
    $query = "SELECT UsuarioId, PasswordHash FROM Usuarios WHERE Email = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->bind_result($usuarioID, $hashAlmacenado);
    $stmt->fetch();

    // Verificar la contraseña usando password_verify
    if (password_verify($password, $hashAlmacenado)) {
        // La contraseña es correcta
        session_start();
        $_SESSION['usuarioID'] = $usuarioID;
        $response['status'] = 'exito';
        $response['message'] = 'Inicio de sesión exitoso';
    } else {
        // La contraseña es incorrecta
        $response['status'] = 'error';
        $response['message'] = 'Correo electrónico o contraseña incorrecta';
    }
} catch (Exception $e) {
    // Manejar la excepción y proporcionar un mensaje de error personalizado
    $response['status'] = 'error';
    $response['message'] = 'Error al autenticar: ' . $e->getMessage();
}

// Cerrar la conexión
$stmt->close();
$conexion->close();

// Devolver la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($response);

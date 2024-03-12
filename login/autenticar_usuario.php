<?php
// Incluir el archivo de configuración
require '../tools/config.php';

// Variables de entrada (validación básica)
$email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) : null;
$password = isset($_POST['password']) ? $_POST['password'] : null;

// Array para la respuesta JSON
$response = array();

try {
    // Validar la entrada
    if (!$email || !$password) {
        throw new Exception('Correo electrónico o contraseña no válidos.');
    }

    // Conexión a la base de datos
    $conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    // Consulta preparada para obtener el hash de la contraseña del usuario
    $query = "SELECT UsuarioId, PasswordHash, Rol FROM Usuarios WHERE Email = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->bind_result($usuarioID, $hashAlmacenado, $rol);
    $stmt->fetch();

    // Verificar la contraseña usando password_verify
    if (password_verify($password, $hashAlmacenado)) {
        // La contraseña es correcta
        session_start();

        // Verificar si intentar_pago está presente en la solicitud
        $intentarPago = isset($_SESSION['intentar_pago']) ? true : false;
        $_SESSION['intentar_pago'] = false;
        $_SESSION['usuarioID'] = $usuarioID;
        $_SESSION['rol'] = $rol;
        $response['status'] = 'exito';
        $response['message'] = 'Inicio de sesión exitoso';
        $response['intentar_pago'] = $intentarPago;
    } else {
        // La contraseña es incorrecta
        $response['status'] = 'error';
        $response['message'] = 'Correo electrónico o contraseña incorrecta';
    }
} catch (Exception $e) {
    // Manejar la excepción y proporcionar un mensaje de error personalizado
    $response['status'] = 'error';
    $response['message'] = 'Error al autenticar: ' . $e->getMessage();
} finally {
    // Cerrar la conexión
    if (isset($stmt)) {
        $stmt->close();
    }
    if (isset($conexion)) {
        $conexion->close();
    }
}

// Devolver la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($response);

<?php
// Incluir el archivo de configuración
require '../tools/config.php';
require '../tools/jwt.php';
require '../tools/sed.php';

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
    $query = "SELECT UsuarioId, PasswordHash, Rol, Verificado FROM usuarios WHERE Email = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->bind_result($usuarioID, $hashAlmacenado, $rol, $verificado);
    $stmt->fetch();

    // Verificar si el usuario está verificado
    if ($verificado == 0) {
        // La cuenta no está activada
        throw new Exception('Tu cuenta no está activada. Por favor, revisa tu correo electrónico para activarla.');
    }

    // Verificar la contraseña usando password_verify
    if (password_verify($password, $hashAlmacenado)) {
        // La contraseña es correcta
        session_start();

        // Verificar si intentar_pago está presente en la solicitud
        $intentarPago = isset($_SESSION['intentar_pago']) ? true : false;
        $_SESSION['intentar_pago'] = false;
        $_SESSION['usuarioID'] = $usuarioID;
        $_SESSION['rol'] = $rol;
        $_SESSION['verificado'] = $verificado;
        $response['status'] = 'exito';
        $response['message'] = 'Inicio de sesión exitoso';
        $response['intentar_pago'] = $intentarPago;

        // Encriptar el usuarioID
        $usuarioID_encriptado = encriptarUsuarioID($usuarioID, SECRET_KEY);

        // Genera el token JWT  
        $payload = array(
            "usuarioID" => $usuarioID_encriptado,
            "email" => $email,
            "exp" => time() + 3600 // Expira en una hora
        );
        //Llamar al JWT para hacer encode
        $token = jwt_encode($payload, SECRET_KEY);

        // Agregar el token JWT a la respuesta
        $response['status'] = 'exito';
        $response['message'] = 'Inicio de sesión exitoso';
        $response['intentar_pago'] = $intentarPago;
        $response['token'] = $token;
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

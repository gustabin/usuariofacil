<?php
// Incluir el archivo de configuración
require '../tools/config.php';

// Array para la respuesta JSON
$response = array();

try {
    // Conexión a la base de datos
    $conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    // Recibir la nueva contraseña del formulario
    // Verificar si el formulario ha sido enviado
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Recibir los valores del formulario y limpiarlos
        $password = mysqli_real_escape_string($conexion, $_POST['password']);
        $retypePassword = mysqli_real_escape_string($conexion, $_POST['retipearPassword']);
        $token = mysqli_real_escape_string($conexion, $_POST['token']);

        // Verificar si los campos de contraseña y repetir contraseña son iguales
        if ($password === $retypePassword) {
            // Verificar la fortaleza de la contraseña
            if (preg_match('/^(?=.*\d)(?=.*[A-Za-z])(?=.*[$@#!%*?&])[A-Za-z\d$@#!%*?&]{8,}$/', $password)) {
                // Hashear la nueva contraseña
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Actualizar la contraseña en la base de datos utilizando el token
                $query = "UPDATE usuarios SET PasswordHash = ? WHERE TokenRecuperacion = ?";
                $stmt = $conexion->prepare($query);
                $stmt->bind_param('ss', $hashedPassword, $token);
                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    $response['status'] = 'exito';
                    $response['message'] = 'Contraseña cambiada exitosamente';
                } else {
                    $response['status'] = 'error';
                    $response['message'] = 'No se pudo cambiar la contraseña. El token puede ser inválido.';
                }
            } else {
                $response['status'] = 'error';
                $response['message'] = 'La contraseña debe tener al menos 8 caracteres, incluyendo al menos un número, una letra mayúscula, una minúscula y un carácter especial.';
            }
        } else {
            // Las contraseñas no coinciden, muestra un mensaje de error o toma la acción necesaria
            $response['status'] = 'error';
            $response['message'] = 'Las contraseñas no coinciden';
        }
    }
} catch (Exception $e) {
    // Manejar la excepción y proporcionar un mensaje de error personalizado
    $response['status'] = 'error';
    $response['message'] = 'Error al actualizar la contraseña.';
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

<?php
session_start();
// Incluir el archivo de configuración
require '../tools/config.php';

// Conexión a la base de datos (usando MySQLi)
$conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if (isset($_POST['csrf_token']) && hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    // Variables de entrada
    $nombre = isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : '';
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
    $telefono = isset($_POST['telefono']) ? htmlspecialchars($_POST['telefono']) : '';
    $mensaje = isset($_POST['mensaje']) ? htmlspecialchars($_POST['mensaje']) : '';

    // Array para la respuesta JSON
    $response = array();

    try {
        // Validar que los campos no estén vacíos y realizar otras validaciones específicas
        if (empty($nombre) || empty($email) || empty($telefono) || empty($mensaje) || !$email) {
            throw new Exception('Por favor, complete todos los campos correctamente.');
        }

        // Consulta preparada para insertar un nuevo contacto
        $query = "INSERT INTO contactos (Nombre, Email, Telefono, Mensaje, Fecha) VALUES (?, ?, ?, ?, NOW())";
        $stmt = $conexion->prepare($query);

        if (!$stmt) {
            throw new Exception('Error en la preparación de la consulta: ' . $conexion->error);
        }

        $stmt->bind_param('ssss', $nombre, $email, $telefono, $mensaje);
        $stmt->execute();

        // Verificar si la operación fue exitosa
        if ($stmt->affected_rows > 0) {
            // Éxito al insertar el contacto
            $response['status'] = 'exito';
            $response['message'] = 'Contacto registrado correctamente';
        } else {
            // Error al insertar el contacto
            throw new Exception('Error al registrar el contacto: No se realizaron cambios.');
        }
    } catch (Exception $e) {
        // Manejar la excepción y loguear el error
        error_log('Error en registrar_contacto.php: ' . $e->getMessage());
        $response['status'] = 'error';
        $response['message'] = 'Error al registrar el contacto. Por favor, inténtelo de nuevo.';
    } finally {
        // Cerrar la conexión
        if (isset($stmt)) {
            $stmt->close();
        }
        if (isset($conexion)) {
            $conexion->close();
        }
    }

    // Regenera un nuevo token CSRF después de procesar el formulario
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

    // Devolver la respuesta en formato JSON
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Token CSRF no válido, puede ser un intento CSRF
    // Manejar el error o redirigir a una página de error
    die("Intento de CSRF detectado.");
}

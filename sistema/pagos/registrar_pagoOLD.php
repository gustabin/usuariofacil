<?php
// Incluir el archivo de configuración
require '../../tools/config.php';
$conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
// Variables de entrada
session_start();
// Verificar si la sesión está iniciada y si la clave 'usuarioID' está definida
if (session_status() == PHP_SESSION_NONE || !isset($_SESSION['usuarioID'])) {
    $response['status'] = 'error';
    $response['message'] = 'La sesión no está iniciada o no se ha proporcionado el usuarioID';
    echo json_encode($response);
    exit;
}
$response = array();

try {
    $producto = $_POST['producto'];
    $monto = floatval($_POST['monto']);

    if (empty($producto) || $monto <= 0) {
        throw new Exception('Datos de pago no válidos.');
    }

    session_start();
    $usuarioID = $_SESSION['usuarioID'];

    $query = "INSERT INTO pagos (UsuarioID, Producto, Monto) VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($query);

    if (!$stmt) {
        throw new Exception('Error en la preparación de la consulta: ' . $conexion->error);
    }

    $stmt->bind_param('isd', $usuarioID, $producto, $monto);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $response['status'] = 'exito';
        $response['message'] = 'Pago realizado correctamente.';
    } else {
        throw new Exception('Error al realizar el pago: No se realizaron cambios.');
    }
} catch (Exception $e) {
    $response['status'] = 'error';
    $response['message'] = 'Error al realizar el pago: ' . $e->getMessage();
}

$stmt->close();
$conexion->close();

header('Content-Type: application/json');
echo json_encode($response);

<?php
// Incluir el archivo de configuración
require '../../tools/config.php';

// Conexión a la base de datos
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

// Array para la respuesta JSON
$response = array();

if ($conexion->connect_error) {
    $response['error'] = "Error de conexión: " . $conexion->connect_error;
} else {
    try {
        // Consulta preparada para obtener los pagos
        $query = "SELECT PagoID, UsuarioID, Monto, Pagado FROM pagos";
        $stmt = $conexion->prepare($query);

        if ($stmt) {
            // Ejecutar la consulta
            $stmt->execute();

            // Obtener el resultado
            $result = $stmt->get_result();

            if ($result) {
                // Obtener los pagos en un array asociativo
                $pagos = $result->fetch_all(MYSQLI_ASSOC);

                // Aplicar htmlspecialchars a cada valor en el array
                $pagos = array_map(function ($pago) {
                    return array_map('htmlspecialchars', $pago);
                }, $pagos);

                // JSON encode para enviar al frontend
                echo json_encode($pagos);
            } else {
                throw new Exception("Error al obtener los pagos");
            }

            // Cerrar el statement
            $stmt->close();
        } else {
            throw new Exception("Error al preparar la consulta");
        }
    } catch (Exception $e) {
        $response['error'] = $e->getMessage();
    }
}

// Cierra la conexión
$conexion->close();

// Devolver la respuesta en formato JSON
// header('Content-Type: application/json');
// echo json_encode($response);

<?php
// Incluir el archivo de configuración
require '../tools/config.php';

// Conexión a la base de datos
$conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
mysqli_set_charset($conexion, 'utf8');

// Crea un array para almacenar los productos
$productos = array();
// Consulta para obtener los productos
$sql = 'SELECT * FROM Productos'; // Corregido a "Productos"
$stmt = $conexion->prepare($sql);

// Ejecuta la consulta
$stmt->execute();

// Obtiene los resultados
$result = $stmt->get_result();

// Verifica si hay resultados
if ($result->num_rows > 0) {
    // Itera sobre los resultados y agrega cada producto al array
    while ($fila = $result->fetch_assoc()) {
        $productos[] = $fila;
    }
    // Establece el encabezado Content-Type como application/json
    header('Content-Type: application/json');
    // Devuelve los productos en formato JSON
    die(json_encode($productos));
} else {
    // Si no hay resultados, devuelve un array vacío
    echo json_encode(array());
}

$stmt->close(); // Cierra la declaración preparada
$conexion->close();

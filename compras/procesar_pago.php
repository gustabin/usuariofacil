<?php
session_start();
// Obtener datos del cliente
$productos = isset($_POST['productos']) ? $_POST['productos'] : [];

if (!isset($_SESSION['usuarioID'])) {
    $_SESSION['intentar_pago'] = true;
    $_SESSION['carrito'] = $productos;
    $response['redirect'] = 'login/index.html';
    $response['message'] = 'Usuario no autenticado';
    // Redirige al usuario a la página de inicio de sesión
    // header("Location: ../login/index.html");
    echo json_encode($response);
    exit();
} else {
    $usuarioID =  $_SESSION['usuarioID'];
    unset($_SESSION['intentar_pago']);

    // Array para la respuesta JSON
    $response = array();

    // Calcular el total a pagar en el servidor
    $totalPagar = calcularTotalPagar($productos);

    // Guardar el pedido y obtener el resultado
    guardarPedidoEnBaseDeDatos($productos, $totalPagar, $usuarioID);
    $response['status'] = 'exito';
    $response['message'] = 'Pago realizado con éxito';
    echo json_encode($response);
}

function calcularTotalPagar($productos)
{
    try {
        // Validar que la entrada sea un array de productos
        if (!is_array($productos)) {
            throw new Exception("La entrada debe ser un array de productos.");
        }

        $totalPagar = 0;

        // Incluir el archivo de configuración
        require '../tools/config.php';

        // Conexión a la base de datos
        $conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);


        //ojo aplicar esto en los demas archivos ***************************************
        // Validar la conexión
        if ($conexion->connect_error) {
            throw new Exception("Error de conexión a la base de datos: " . $conexion->connect_error);
        }

        // Recorrer cada producto en el array
        foreach ($productos as $productoDetalle) {
            // Validar que el producto sea un array asociativo con las claves necesarias
            if (
                !is_array($productoDetalle) || !array_key_exists('producto', $productoDetalle) || !array_key_exists('cantidad', $productoDetalle)
            ) {
                throw new Exception("Detalles de producto incorrectos.");
            }

            $productoID = intval($productoDetalle['producto']['ProductoID']);
            // Obtener la cantidad del producto del carrito de compras
            $cantidad = intval($productoDetalle['cantidad']);
            // Validar que la cantidad sea un valor positivo
            if ($cantidad < 0) {
                throw new Exception("Cantidad negativa en los detalles del producto.");
            }

            // Obtener el precio del producto desde la base de datos
            $queryPrecio = "SELECT Precio FROM Productos WHERE ProductoID = ?";
            $stmtPrecio = $conexion->prepare($queryPrecio);
            $stmtPrecio->bind_param('i', $productoID);
            $stmtPrecio->execute();
            $resultPrecio = $stmtPrecio->get_result();

            // Verificar si se obtuvo un resultado
            if ($resultPrecio->num_rows > 0) {
                $rowPrecio = $resultPrecio->fetch_assoc();
                $precio = floatval($rowPrecio['Precio']);
                // Validar que el precio y la cantidad sean valores positivos
                if ($precio < 0) {
                    throw new Exception("Valores negativos en el precio del producto.");
                }
                // Calcular el total considerando la cantidad
                $totalPagar += $precio * $cantidad;
            } else {
                throw new Exception("No se encontró el producto con ID $productoID.");
            }

            // Cerrar la consulta
            $stmtPrecio->close();
        }
        // Cerrar la conexión a la base de datos
        $conexion->close();
        return $totalPagar;
    } catch (Exception $e) {
        // Manejar cualquier excepción y registrarla
        echo "Error al calcular el total a pagar: " . $e->getMessage();
        return null;
    }
}

function guardarPedidoEnBaseDeDatos($productos, $totalPagar, $usuarioID)
{
    // Conexión a la base de datos
    $conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    // Validar la conexión
    if ($conexion->connect_error) {
        throw new Exception("Error de conexión a la base de datos: " . $conexion->connect_error);
    }


    // Declarar $stmtPedido
    $stmtPedido = null;

    // Declarar $stmtProductosPedidos
    $stmtProductosPedidos = null;

    // Declarar $stmtPagos
    $stmtPagos = null;


    // Guardar en la tabla Pedidos, en la tabla ProductosPedidos y guardar en la tabla Pagos 
    try {
        // Comienza una transacción
        $conexion->begin_transaction();

        // 1. Insertar en la tabla "Pedidos"
        $queryPedido = "INSERT INTO Pedidos (UsuarioID, FechaPedido) VALUES (?, NOW())";
        $stmtPedido = $conexion->prepare($queryPedido);
        $stmtPedido->bind_param('i', $usuarioID);
        $stmtPedido->execute();

        // Obtener el ID del pedido recién insertado
        $pedidoId = $stmtPedido->insert_id;

        // 2. Insertar en la tabla "ProductosPedidos"
        $queryProductosPedidos = "INSERT INTO ProductosPedidos (PedidoID, ProductoID, Cantidad) VALUES (?, ?, ?)";
        $stmtProductosPedidos = $conexion->prepare($queryProductosPedidos);

        foreach ($productos as $productoDetalle) {
            $producto = $productoDetalle['producto'];  // Obtener el array 'producto'
            $cantidad = intval($productoDetalle['cantidad']);  // Obtener la cantidad

            $stmtProductosPedidos->bind_param('iii', $pedidoId, $producto['ProductoID'], $cantidad);
            $stmtProductosPedidos->execute();
        }


        // 3. Insertar en la tabla "Pagos"
        $queryPagos = "INSERT INTO Pagos (UsuarioID, Monto, Pagado) VALUES (?, ?, false)";
        $stmtPagos = $conexion->prepare($queryPagos);
        $stmtPagos->bind_param('id', $usuarioID, $totalPagar);
        $stmtPagos->execute();

        // Confirmar la transacción
        $conexion->commit();
        $response['status'] = 'exito';
        $response['message'] = 'Pedido registrado correctamente';
        $response['totalPagar'] = $totalPagar;
    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $conexion->rollback();

        $response['status'] = 'error';
        $response['message'] = 'Error al registrar el pedido: ' . $e->getMessage();
    }

    // Cerrar las conexiones
    // Cerrar $stmtPedido solo si está definido
    if ($stmtPedido !== null) {
        $stmtPedido->close();
    }

    // Cerrar $stmtProductosPedidos solo si está definido
    if ($stmtProductosPedidos !== null) {
        $stmtProductosPedidos->close();
    }

    // Cerrar $stmtPagos solo si está definido
    if ($stmtPagos !== null) {
        $stmtPagos->close();
    }

    // $stmtPagos->close();
    $conexion->close();

    // Limpiar la variable de sesión del carrito
    unset($_SESSION['carrito']);

    // Devolver la respuesta en formato JSON
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}

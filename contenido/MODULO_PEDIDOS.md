Aquí tienes un ejemplo básico de cómo podrías diseñar la interfaz para que los usuarios realicen pedidos de productos. Utilizaré Bootstrap, jQuery y SweetAlert.

1. **HTML (realizar-pedido.html):**

```html
<?php
$nombre_usuario = "Nombre del usuario";
$modulo = "Pedidos";
require_once("../tools/header.php");
?>

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <?php
        require_once("../tools/navbar.php");
        ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php
        require_once("../tools/aside.php");
        ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <?php
            require_once("../tools/breadcrumbs.php");
            ?>

            <!-- Main content -->
            <section class="content">
                <!-- Default box -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo $modulo ?></h3>
                        <div class="card-tools"></div>
                    </div>
                    <div class="card-body">
                        <div class="container">
                            <form id="pedidoForm" class="row justify-content-center align-items-center">
                                <div class="form-group col-12 col-md-4 mb-3">
                                    <label for="selectProducto" class="sr-only">Producto:</label>
                                    <select class="form-control" id="selectProducto" required>
                                        <!-- Opciones de productos que puedes cargar dinámicamente desde la base de datos -->
                                        <option value="producto1">Producto 1</option>
                                        <option value="producto2">Producto 2</option>
                                        <!-- Agrega más opciones según tus productos -->
                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-3 mb-3">
                                    <label for="inputCantidad" class="sr-only">Cantidad:</label>
                                    <input type="number" class="form-control" id="inputCantidad" min="1" required>
                                </div>
                                <div class="form-group col-12 col-md-2 mb-3">
                                    <button type="submit" class="btn btn-primary btn-block">Realizar Pedido</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- /.card-body -->
                    <div class="card-footer">
                        Footer
                    </div>
                    <!-- /.card-footer-->
                </div>
                <!-- /.card -->

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <?php
        require_once("../tools/footer.php");
        ?>
    </div>
    <!-- ./wrapper -->

    <?php
    require_once("../tools/scripts.php");
    ?>
    <!-- Sweet Alert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="pedidos/pedidos.js"></script>
</body>

</html>
```

2. **JavaScript (pedidos.js):**

```javascript
$(document).ready(function () {
    $("#pedidoForm").submit(function (event) {
        event.preventDefault(); // Detener el envío del formulario convencional
        var producto = $("#selectProducto").val();
        var cantidad = $("#inputCantidad").val();

        // Validar que se haya seleccionado un producto y la cantidad sea válida
        if (!producto || cantidad <= 0) {
            // Mostrar SweetAlert de error
            Swal.fire({
                icon: 'error',
                title: 'Error en el Pedido',
                text: 'Selecciona un producto y especifica una cantidad válida.',
            });
            return;
        }
        // Enviar solicitud AJAX para procesar el pedido
        $.ajax({
            type: "POST",
            url: "pedidos/registrar_pedido.php", // Especifica la ruta a tu controlador PHP en el backend
            data: { producto: producto, cantidad: cantidad },
            success: function (response) {
                // console.log(response);
                // Procesar la respuesta del servidor
                if (response.status === 'exito') {
                    Swal.fire('Éxito', response.message, 'success');
                } else {
                    Swal.fire('Error', response.message, 'error');
                }                
            },
            error: function () {
                // Mostrar SweetAlert de error en caso de fallo en la solicitud AJAX
                Swal.fire({
                    icon: 'error',
                    title: 'Error en la Solicitud',
                    text: 'Hubo un problema al comunicarse con el servidor.',
                });
            }
        });
    });
});
```

3. **PHP (registrar_pedido.php):**

```php
<?php
// Conexión a la base de datos
$conexion = new mysqli('localhost', 'root', '', 'usuariofacil');

// Variables de entrada
$producto = $_POST['producto'];
$cantidad = intval($_POST['cantidad']);

// Array para la respuesta JSON
$response = array();

try {
    // Validar datos del pedido
    if (empty($producto) || $cantidad <= 0) {
        throw new Exception('Datos de pedido no válidos.');
    }

    session_start();
    // $usuarioID = $_SESSION['usuarioID'];
    $usuarioID = 24;

    // Consulta preparada para insertar un nuevo pedido
    $query = "INSERT INTO Pedidos (UsuarioID, Producto, Cantidad, FechaPedido) VALUES (?, ?, ?, CURRENT_DATE)";
    $stmt = $conexion->prepare($query);

    if (!$stmt) {
        throw new Exception('Error en la preparación de la consulta: ' . $conexion->error);
    }

    $stmt->bind_param('iss', $usuarioID, $producto, $cantidad);
    $stmt->execute();

    // Verificar si la operación fue exitosa
    if ($stmt->affected_rows > 0) {
        // Éxito al insertar el pedido
        $response['status'] = 'exito';
        $response['message'] = 'Pedido realizado correctamente.';
    } else {
        // Error al insertar el pedido
        throw new Exception('Error al realizar el pedido: No se realizaron cambios.');
    }
} catch (Exception $e) {
    // Manejar la excepción y proporcionar un mensaje de error personalizado
    $response['status'] = 'error';
    $response['message'] = 'Error al realizar el pedido: ' . $e->getMessage();
}

// Cerrar la conexión
$stmt->close();
$conexion->close();

// Devolver la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($response);

```

Este es un ejemplo básico, y debes ajustar las rutas, las validaciones y otros detalles según tu aplicación. Además, asegúrate de manejar adecuadamente la seguridad y la conexión segura con tu servidor.
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

                        <div class="card-tools">

                        </div>
                    </div>
                    <div class="card-body">

                        <div class="container">
                            <form id="pedidoForm" class="row justify-content-center align-items-center">
                                <div class="form-group col-12 col-md-4 mb-3">
                                    <label for="selectProducto" class="sr-only">Producto:</label>
                                    <select class="form-control" id="selectProducto" name="producto" required>
                                        <!-- Opciones de productos que puedes cargar dinámicamente desde la base de datos -->
                                        <option value="producto1">Producto 1</option>
                                        <option value="producto2">Producto 2</option>
                                        <!-- Agrega más opciones según tus productos -->
                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-3 mb-3">
                                    <label for="inputCantidad" class="sr-only">Cantidad:</label>
                                    <input type="number" class="form-control" id="inputCantidad" name="cantidad" min="1" required>
                                </div>
                                <div class="form-group col-12 col-md-2 mb-3">
                                    <button type="submit" class="btn btn-primary btn-block">Realizar Pedido</button>
                                </div>
                            </form>
                        </div>


                    </div>
                    <!-- /.card-body -->

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
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

                        <!-- Contenedor principal -->
                        <div class="container mt-5">


                            <!-- Tabla para mostrar los pedidos -->
                            <table id="tablaPedidos" class="table">
                                <thead>
                                    <tr>
                                        <th>ID Pedido</th>
                                        <th>Fecha Pedido</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Los datos de la tabla se llenarán dinámicamente aquí -->
                                </tbody>
                            </table>
                        </div>

                        <!-- Modal para mostrar el detalle del pedido -->
                        <div class="modal" id="detallePedidoModal">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <!-- Encabezado del Modal -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Detalle del Pedido</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Contenido del Modal -->
                                    <div class="modal-body">
                                        <!-- Los detalles del pedido se mostrarán aquí -->
                                    </div>

                                    <!-- Botón para cerrar el Modal -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    </div>

                                </div>
                            </div>
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
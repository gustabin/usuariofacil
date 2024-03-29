<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="dist/img/AdminLTELogo.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Usuario Fácil Store</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="perfil/imagen/user_default.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><span id="nombre_usuario"></span></a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="perfil.php" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Perfil
                        </p>
                    </a>
                </li>
                <?php
                if ($_SESSION['rol'] == 1) {
                ?>
                    <li class="nav-item">
                        <a href="roles.php" class="nav-link">
                            <i class="nav-icon fas fa-user-tie"></i>
                            <p>
                                Roles
                            </p>
                        </a>
                    </li>
                <?php
                }
                ?>
                <?php
                if ($_SESSION['rol'] == 1) {
                ?>
                    <li class="nav-item">
                        <a href="pagos.php" class="nav-link">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                Pagos
                            </p>
                        </a>
                    </li>
                <?php
                }
                ?>
                <li class="nav-item">
                    <a href="pedidos.php" class="nav-link">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>
                            Pedidos
                        </p>
                    </a>
                </li>
                <?php
                if ($_SESSION['rol'] == 1) {
                ?>
                    <li class="nav-item">
                        <a href="contactos.php" class="nav-link">
                            <i class="nav-icon fas fa-address-book"></i>
                            <p>
                                Contáctos
                            </p>
                        </a>
                    </li>
                <?php
                }
                ?>
                <?php
                if ($_SESSION['rol'] == 1) {
                ?>
                    <li class="nav-item">
                        <a href="pdfUsuarios.php" class="nav-link">
                            <i class="nav-icon fas fa-file-pdf"></i>
                            <p>
                                PDF Usuarios
                            </p>
                        </a>
                    </li>
                <?php
                }
                ?>
                <?php
                if ($_SESSION['rol'] == 1) {
                ?>
                    <li class="nav-item">
                        <a href="pdfProductos.php" class="nav-link">
                            <i class="nav-icon fas fa-file-pdf"></i>
                            <p>
                                PDF Productos
                            </p>
                        </a>
                    </li>
                <?php
                }
                ?>
                <li class="nav-item">
                    <a href="../" class="nav-link">
                        <i class="nav-icon fas fa-store"></i>
                        <p>
                            Ir a la tienda
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="salir.php" class="nav-link">
                        <i class="fas fa-sign-out-alt"></i>
                        <p>
                            Cerrar sesión
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
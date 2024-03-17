<?php
session_start();
?>
<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>
  <script src="js/color-modes.js"></script>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Descubre una experiencia de compra única en GusTech Store. Sumérgete en un mundo de tecnología con nuestra amplia gama de teléfonos celulares de última generación.">
  <meta name="author" content="Ing Gustavo Arias">
  <meta name="generator" content="guskit 2.0">
  <title>GusTech Store</title>

  <link rel="icon" href="imagen/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/compras.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/pricing.css" rel="stylesheet">
</head>

<body>
  <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
    <symbol id="check2" viewBox="0 0 16 16">
      <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z" />
    </symbol>
    <symbol id="circle-half" viewBox="0 0 16 16">
      <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z" />
    </symbol>
    <symbol id="moon-stars-fill" viewBox="0 0 16 16">
      <path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z" />
      <path d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z" />
    </symbol>
    <symbol id="sun-fill" viewBox="0 0 16 16">
      <path d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z" />
    </symbol>
  </svg>

  <div class="dropdown position-fixed bottom-0 end-0 mb-3 me-3 bd-mode-toggle">
    <button class="btn btn-bd-primary py-2 dropdown-toggle d-flex align-items-center" id="bd-theme" type="button" aria-expanded="false" data-bs-toggle="dropdown" aria-label="Toggle theme (auto)">
      <svg class="bi my-1 theme-icon-active" width="1em" height="1em">
        <use href="#circle-half"></use>
      </svg>
      <span class="visually-hidden" id="bd-theme-text">Toggle theme</span>
    </button>
    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-text">
      <li>
        <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light" aria-pressed="false">
          <svg class="bi me-2 opacity-50 theme-icon" width="1em" height="1em">
            <use href="#sun-fill"></use>
          </svg>
          Light
          <svg class="bi ms-auto d-none" width="1em" height="1em">
            <use href="#check2"></use>
          </svg>
        </button>
      </li>
      <li>
        <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark" aria-pressed="false">
          <svg class="bi me-2 opacity-50 theme-icon" width="1em" height="1em">
            <use href="#moon-stars-fill"></use>
          </svg>
          Dark
          <svg class="bi ms-auto d-none" width="1em" height="1em">
            <use href="#check2"></use>
          </svg>
        </button>
      </li>
      <li>
        <button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="auto" aria-pressed="true">
          <svg class="bi me-2 opacity-50 theme-icon" width="1em" height="1em">
            <use href="#circle-half"></use>
          </svg>
          Auto
          <svg class="bi ms-auto d-none" width="1em" height="1em">
            <use href="#check2"></use>
          </svg>
        </button>
      </li>
    </ul>
  </div>

  <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
    <symbol id="check" viewBox="0 0 16 16">
      <title>Check</title>
      <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z" />
    </symbol>
  </svg>

  <div class="container py-3">
    <header>
      <div class="d-flex flex-column flex-md-row align-items-center pb-3 mb-4 border-bottom">
        <a href="/" class="d-flex align-items-center link-body-emphasis text-decoration-none">
          <img src="imagen/logo.png" alt="logo" style="height: 40px; margin-right:10px">
          <span class="fs-4">GusTech Store</span>
        </a>

        <nav class="d-inline-flex mt-2 mt-md-0 ms-md-auto">
          <a class="me-3 py-2 link-body-emphasis text-decoration-none" href="#">Carrito</a>
          <a class="me-3 py-2 link-body-emphasis text-decoration-none" href="privacidad.html">Privacidad</a>
          <a class="me-3 py-2 link-body-emphasis text-decoration-none" href="contacto.php">Contacto</a>
          <?php
          if (!isset($_SESSION['usuarioID'])) { ?>
            <a class="py-2 link-body-emphasis text-decoration-none" href="login/">Login</a>
          <?php } else { ?>
            <a class="py-2 link-body-emphasis text-decoration-none" href="sistema/">Dashboard</a>
          <?php } ?>
        </nav>
      </div>

      <div class="pricing-header p-3 pb-md-4 mx-auto text-center">
        <h1 class="display-4 fw-normal text-body-emphasis">🧩Tu Conexión al Mañana</h1>
        <p class="fs-5 text-body-secondary">Explora nuestro e-commerce y descubre la última tecnología en celulares.
          Diseños vanguardistas, funciones avanzadas y un mundo de conectividad en tus manos. ¡Bienvenido al futuro de
          la comunicación! 📱✨
        </p>
      </div>
    </header>

    <main>
      <div class="row row-cols-1 row-cols-md-3 mb-3 text-center" id="product-cards">
        <!-- Tarjetas de productos se cargarán aquí -->
      </div>

      <div class="container mt-5">
        <h2>Carrito de Compras</h2>
        <!-- Contenedor del carrito -->
        <div id="carrito" class="row">
          <!-- Aquí se mostrarán los productos en el carrito -->
        </div>
        <!-- Total y botón de pago -->
        <div class="row mt-3">
          <div class="col-12 text-right">
            <h4>Total: $<span id="totalPagar">0.00</span></h4>
            <button id="realizarPagoBtn" class="btn btn-success">Realizar Pago</button>
          </div>
        </div>
      </div>
    </main>

    <div class="container">
      <footer class="py-3 my-4">
        <ul class="nav justify-content-center border-bottom pb-3 mb-3">
          <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Carrito</a></li>
          <li class="nav-item"><a href="privacidad.html" class="nav-link px-2 text-body-secondary">Privacidad</a></li>
          <li class="nav-item"><a href="contacto.php" class="nav-link px-2 text-body-secondary">Contacto</a></li>
          <li class="nav-item"><a href="login/" class="nav-link px-2 text-body-secondary">Login</a></li>
        </ul>
        <p class="text-center text-body-secondary"><a href="https://www.stackcodelab.com" style="text-decoration: none;"> 2024 Stackcodelab, Inc </a></p>
      </footer>
    </div>
  </div>
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <!-- Sweet Alert JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <script src="js/compras.js"></script>
</body>

</html>
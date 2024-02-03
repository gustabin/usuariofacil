<?php
// Inicia la sesión si no está iniciada
session_start();

// Elimina todas las variables de sesión
session_unset();

// Destruye la sesión
session_destroy();

// Redirige a home.html
header("Location: ../index.html");
exit();


<?php
// Iniciar la sesión
session_start();

// Establecer una variable de sesión
$_SESSION['token'] = 'miToken';

// Acceder a la variable de sesión
echo $_SESSION['token'];

$_otra_variable =  $_SESSION['token'];

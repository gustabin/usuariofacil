<?php
session_start();

header('Content-Type: application/json');
// Devolver el contenido de la sesión como JSON
echo json_encode($_SESSION['carrito'] ?? []);

exit();

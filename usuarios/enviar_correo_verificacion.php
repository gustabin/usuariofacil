<?php
// Incluir el archivo de configuración
require '../tools/config.php';
require('../mail/index.php'); // Requerir el archivo de envío de correo

// Generar un número aleatorio para el código
$numeroAleatorio = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);

$reply = "gustabin@yahoo.com"; // Dirección de correo electrónico para respuestas

if (!isset($_POST['email'])) {
        throw new Exception('Por favor, proporciona un correo electrónico y una contraseña.');
}

$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
$token = $_POST['token'];

// Array para la respuesta JSON
$response = array();
// Enviar email al administrador
$subject = "Activar su cuenta - Cod: $numeroAleatorio";
$body = "<h2>Hola,</h2><br><br>
        Un usuario registro una cuenta en usuariofacil <br><br>
        Su email es $email <br><br>
        <a href='https://stackcodelab.com/usuariofacil/usuarios/activacion.php?token=$token'>Activar cuenta</a><br><br>
        El equipo de usuariofacil.<br>
        <img src=https://www.stackcodelab.com/usuariofacil/imagen/logoEmpresa.png height=50px width=50px />
        <a href=https://www.facebook.com/gustabin2.0>
        <img src=https://www.stackcodelab.com/usuariofacil/imagen/logoFacebook.jpg alt=Logo Facebook height=50px width=50px></a>
        <h5>Desarrollado por Gustabin<br>
        Copyright © 2024. Todos los derechos reservados. Version 1.0.0 <br></h5>
        ";
enviarEmail("gustabin@yahoo.com", $subject, $body, $reply);

// Enviar email al usuario
$subject = "Activar su cuenta - Cod: $numeroAleatorio";
$body = "<h2>Hola,</h2><br><br>
        Bienvenido a nuestro sistema usuario facil!.
        Para activar su cuenta, haga clic en el siguiente enlace: <br><br>
        <a href='https://stackcodelab.com/usuariofacil/usuarios/activacion.php?token=$token'>Activar cuenta</a><br><br>
        El equipo de usuariofacil.<br>
        <img src=https://www.stackcodelab.com/usuariofacil/imagen/logoEmpresa.png height=50px width=50px />
        <a href=https://www.facebook.com/gustabin2.0>
        <img src=https://www.stackcodelab.com/usuariofacil/imagen/logoFacebook.jpg alt=Logo Facebook height=50px width=50px></a>
        <h5>Desarrollado por Gustabin<br>
        Copyright © 2024. Todos los derechos reservados. Version 1.0.0 <br></h5>
        ";

enviarEmail($email, $subject, $body, $reply);
// Preparar la respuesta exitosa
$response['status'] = 'exito';

// Devolver la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($response);

<?php

require '../tools/config.php';
$conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

$response = array();

try {
    // Validación de datos del formulario
    if (!isset($_POST['email'], $_POST['password'])) {
        throw new Exception('Por favor, proporciona un correo electrónico y una contraseña.');
    }

    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];

    if (!$email || empty($password)) {
        throw new Exception('Por favor, proporciona un correo electrónico válido y una contraseña.');
    }

    // Consulta preparada para insertar un nuevo usuario
    $query = "INSERT INTO usuarios (Email, PasswordHash, TokenRecuperacion) VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($query);

    if (!$stmt) {
        throw new Exception('Error en la preparación de la consulta: ' . $conexion->error);
    }

    $token = bin2hex(random_bytes(32));

    // Almacenar el resultado de password_hash en una variable
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Escapar datos para evitar SQL injection
    $stmt->bind_param('sss', $email, $hashedPassword, $token);
    $stmt->execute();

    // Obtener el ID del usuario recién insertado
    $usuarioID = $stmt->insert_id;

    // Consulta preparada para insertar un nuevo perfil asociado al usuario
    $queryPerfil = "INSERT INTO perfiles (UsuarioID, Nombre, Apellido, AvatarURL) VALUES (?, ?, ?, ?)";
    $stmtPerfil = $conexion->prepare($queryPerfil);

    if (!$stmtPerfil) {
        throw new Exception('Error en la preparación de la consulta para el perfil: ' . $conexion->error);
    }

    // Valores para el nuevo perfil (puedes ajustar esto según tus necesidades)
    $nombre = 'John';
    $apellido = 'Doe';
    $avatarURL = 'imagen/user_default.png';

    $stmtPerfil->bind_param('isss', $usuarioID, $nombre, $apellido, $avatarURL);
    $stmtPerfil->execute();

    // Cerrar la conexión para el perfil
    $stmtPerfil->close();

    if ($stmt->affected_rows > 0) {
        require('../mail/index.php'); // Requerir el archivo de envío de correo

        // Generar un número aleatorio para el código
        $numeroAleatorio = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);

        $reply = "gustabin@yahoo.com"; // Dirección de correo electrónico para respuestas

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
        $response['message'] = 'Usuario registrado correctamente';
    } else {
        throw new Exception('Error al registrar el usuario: No se realizaron cambios.');
    }
} catch (Exception $e) {
    error_log("Error al registrar el usuario: " . $e->getMessage());
    $response['status'] = 'error';
    $response['message'] = 'Error al registrar el usuario. Ese correo ya se encuentra registrado.';
}

$stmt->close();
$conexion->close();

header('Content-Type: application/json');
echo json_encode($response);

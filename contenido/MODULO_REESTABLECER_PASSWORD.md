Enviaremos el email utilizando PHPMailer, primero necesitarás descargar e incluir la biblioteca en tu proyecto. Puedes obtener PHPMailer desde su [sitio oficial en GitHub](https://github.com/PHPMailer/PHPMailer).

A continuación, te proporcionaré un ejemplo básico de cómo puedes modificar tu código para enviar un correo electrónico utilizando PHPMailer:

```php
<?php
//Importar clases PHPMailer al espacio de nombres global
//Estos deben estar en la parte superior de tu script, no dentro de una función
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

$email= 'stackcodelab@gmail.com';
$token = "valor_del_token_hardcode";

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);


$mail->SMTPDebug = 0;
$mail->isSMTP();
$mail->Host       = 'smtp.gmail.com';
$mail->SMTPAuth   = 'true';
$mail->Username   = 'stackcodelab@gmail.com';
$mail->Password   = 'jerzygoscnqzuhqh';
$mail->SMTPSecure = 'ssl';
$mail->Port       = 465;

$mail->setFrom('stackcodelab@gmail.com', 'Soporte Stackcodelab');
$mail->addAddress($email);
$mail->CharSet = 'UTF-8';

//Contenido
$mail->isHTML(true);
$mail->Subject = 'Restablecimiento de Contraseña';
$mail->Body    = "Hola,\n\nHemos recibido una solicitud para restablecer tu contraseña. " .
    "Haz clic en el siguiente enlace para restablecer tu contraseña:\n\n" .
    "http://tudominio.com/restablecer.php?token=$token\n\n" .
    "Si no solicitaste este restablecimiento, puedes ignorar este correo.";
try {
    $mail->send();
    echo 'El correo electrónico ha sido enviado.';
} catch (Exception $e) {
    echo "Error al enviar el correo electrónico: {$mail->ErrorInfo}";
}
?>
```

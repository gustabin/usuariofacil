La validación en el servidor es crucial para garantizar que los datos recibidos desde el cliente sean seguros y cumplan con los requisitos específicos de la aplicación. A continuación, te proporcionaré algunos ejemplos de validación en el servidor utilizando PHP y MySQL:

### Ejemplo 1: Validación de Campos Obligatorios

```php
<?php
// Supongamos que estos datos provienen de un formulario
$nombre = $_POST['nombre'];
$email = $_POST['email'];

// Validación de campos obligatorios
if (empty($nombre) || empty($email)) {
    echo "Por favor, complete todos los campos obligatorios.";
} else {
    // Resto del código PHP para procesar los datos
}
?>
```

### Ejemplo 2: Validación de Dirección de Correo Electrónico

```php
<?php
$email = $_POST['email'];

// Validación de dirección de correo electrónico
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "La dirección de correo electrónico no es válida.";
} else {
    // Resto del código PHP para procesar los datos
}
?>
```

### Ejemplo 3: Validación de Longitud de Contraseña

```php
<?php
$contrasena = $_POST['contrasena'];

// Validación de longitud de contraseña
if (strlen($contrasena) < 8) {
    echo "La contraseña debe tener al menos 8 caracteres.";
} else {
    // Resto del código PHP para procesar los datos
}
?>
```

### Ejemplo 4: Validación de Números Enteros

```php
<?php
$edad = $_POST['edad'];

// Validación de números enteros
if (!ctype_digit($edad) || $edad <= 0) {
    echo "Por favor, ingrese una edad válida.";
} else {
    // Resto del código PHP para procesar los datos
}
?>
```

### Ejemplo 5: Validación de Existencia de Usuario en la Base de Datos

```php
<?php
$nombre_usuario = $_POST['nombre_usuario'];

// Validación de existencia de usuario en la base de datos
$conn = new mysqli("localhost", "usuario", "contraseña", "basededatos");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$sql = "SELECT * FROM usuarios WHERE nombre_usuario = '$nombre_usuario'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "El nombre de usuario ya está en uso. Por favor, elija otro.";
} else {
    // Resto del código PHP para procesar los datos
}

$conn->close();
?>
```

Estos son ejemplos básicos de validación en el servidor. Recuerda que la validación debe adaptarse a los requisitos específicos de tu aplicación y tener en cuenta consideraciones de seguridad, como la prevención de inyecciones SQL y la validación de datos para evitar ataques. Además, considera el uso de funciones como `htmlspecialchars` para mitigar riesgos de XSS al mostrar datos en la interfaz de usuario.
La prevención de la inyección de SQL es una parte fundamental de la seguridad de una aplicación web. Aquí tienes algunos ejemplos de cómo prevenir la inyección de SQL en PHP al interactuar con una base de datos MySQL utilizando consultas preparadas y parámetros vinculados:

### Ejemplo 1: Consulta Preparada con mysqli

```php
<?php
// Supongamos que estos datos provienen de un formulario
$nombre_usuario = $_POST['nombre_usuario'];
$contrasena = $_POST['contrasena'];

// Conexión a la base de datos
$conn = new mysqli("localhost", "usuario", "contraseña", "basededatos");

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta preparada para evitar la inyección de SQL
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE nombre_usuario = ? AND contrasena = ?");
$stmt->bind_param("ss", $nombre_usuario, $contrasena);

// Ejecutar la consulta
$stmt->execute();

// Obtener resultados
$result = $stmt->get_result();

// Procesar los resultados (aquí puedes validar si se encontró el usuario, etc.)

// Cerrar la conexión
$stmt->close();
$conn->close();
?>
```

### Ejemplo 2: Consulta Preparada con PDO

```php
<?php
// Supongamos que estos datos provienen de un formulario
$nombre_usuario = $_POST['nombre_usuario'];
$contrasena = $_POST['contrasena'];

// Conexión a la base de datos usando PDO
$conn = new PDO("mysql:host=localhost;dbname=basededatos", "usuario", "contraseña");

// Consulta preparada para evitar la inyección de SQL
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE nombre_usuario = :nombre_usuario AND contrasena = :contrasena");
$stmt->bindParam(':nombre_usuario', $nombre_usuario, PDO::PARAM_STR);
$stmt->bindParam(':contrasena', $contrasena, PDO::PARAM_STR);

// Ejecutar la consulta
$stmt->execute();

// Obtener resultados
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Procesar los resultados (aquí puedes validar si se encontró el usuario, etc.)

// Cerrar la conexión
$conn = null;
?>
```

Estos ejemplos utilizan consultas preparadas, que permiten separar los datos de la consulta SQL real. Además, al vincular parámetros, te proteges contra la inyección de SQL, ya que los datos proporcionados se tratan como datos y no como parte de la consulta SQL. Es importante utilizar consultas preparadas siempre que sea posible en lugar de concatenar directamente valores en las consultas SQL.
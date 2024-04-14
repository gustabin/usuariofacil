La implementación de un sistema de autenticación y autorización robusto en el backend es crucial para garantizar la seguridad de tu aplicación. A continuación, proporcionaré ejemplos utilizando PHP y MySQL, centrándonos en la autenticación con contraseñas seguras y el control de acceso basado en roles.

### Autenticación Robusta:

#### 1. Registro de Usuario (Registro.php):

```php
<?php
// Conexión a la base de datos (suponiendo que $conn es un objeto mysqli)
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir datos del formulario
    $nombre_usuario = $_POST['nombre_usuario'];
    $correo = $_POST['correo'];
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_BCRYPT); // Hash de la contraseña

    // Insertar usuario en la base de datos
    $stmt = $conn->prepare("INSERT INTO usuarios (nombre_usuario, correo, contrasena) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nombre_usuario, $correo, $contrasena);

    if ($stmt->execute()) {
        echo "Registro exitoso";
    } else {
        echo "Error en el registro";
    }

    $stmt->close();
    $conn->close();
}
?>
```

#### 2. Inicio de Sesión (InicioSesion.php):

```php
<?php
// Conexión a la base de datos (suponiendo que $conn es un objeto mysqli)
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir datos del formulario
    $nombre_usuario = $_POST['nombre_usuario'];
    $contrasena = $_POST['contrasena'];

    // Obtener datos del usuario
    $stmt = $conn->prepare("SELECT id, nombre_usuario, contrasena FROM usuarios WHERE nombre_usuario = ?");
    $stmt->bind_param("s", $nombre_usuario);
    $stmt->execute();
    $stmt->bind_result($id, $usuario, $hash_contrasena);
    $stmt->fetch();

    // Verificar la contraseña
    if (password_verify($contrasena, $hash_contrasena)) {
        // Iniciar sesión (puedes usar sesiones de PHP)
        session_start();
        $_SESSION['id_usuario'] = $id;
        $_SESSION['nombre_usuario'] = $usuario;

        echo "Inicio de sesión exitoso";
    } else {
        echo "Nombre de usuario o contraseña incorrectos";
    }

    $stmt->close();
    $conn->close();
}
?>
```

### Autorización Robusta (Basada en Roles):

#### 1. Crear Roles en la Base de Datos:

```sql
CREATE TABLE roles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(255) NOT NULL UNIQUE
);

INSERT INTO roles (nombre) VALUES ('admin'), ('usuario');
```

#### 2. Asignar Roles a Usuarios:

```sql
CREATE TABLE usuarios_roles (
    usuario_id INT,
    rol_id INT,
    PRIMARY KEY (usuario_id, rol_id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    FOREIGN KEY (rol_id) REFERENCES roles(id)
);

-- Asignar roles a un usuario específico
INSERT INTO usuarios_roles (usuario_id, rol_id) VALUES (1, 1); -- Usuario 1 tiene el rol de admin
```

#### 3. Verificar Roles al Acceder a Recursos Protegidos:

```php
<?php
session_start();

// Verificar si el usuario tiene el rol necesario
function verificarRol($rolNecesario) {
    if (isset($_SESSION['id_usuario'])) {
        // Consultar roles del usuario
        $usuario_id = $_SESSION['id_usuario'];
        // Suponiendo que $conn es la conexión a la base de datos
        $stmt = $conn->prepare("SELECT r.nombre FROM roles r
                                INNER JOIN usuarios_roles ur ON r.id = ur.rol_id
                                WHERE ur.usuario_id = ? AND r.nombre = ?");
        $stmt->bind_param("is", $usuario_id, $rolNecesario);
        $stmt->execute();
        $stmt->store_result();
        
        return $stmt->num_rows > 0;
    }

    return false;
}

// Ejemplo de uso en una página protegida
if (verificarRol('admin')) {
    // El usuario tiene el rol de admin, permitir acceso
    echo "Acceso permitido para administradores";
} else {
    // Redirigir o mostrar un mensaje de error
    echo "Acceso denegado";
}
?>
```

Estos son ejemplos básicos y deberías ajustarlos según las necesidades específicas de tu aplicación y el marco de desarrollo que estés utilizando. Además, considera utilizar bibliotecas de autenticación y autorización existentes para manejar estas tareas de manera más segura y eficiente.
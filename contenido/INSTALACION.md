# Instrucciones de Instalación y Uso del Sistema

Estas instrucciones detallan los pasos necesarios para instalar y utilizar el Sistema de Información. Asegúrate de seguir cada paso cuidadosamente para garantizar una instalación exitosa y un uso efectivo del sistema.

## Requisitos Previos

Antes de comenzar con la instalación, asegúrate de tener los siguientes requisitos previos:

1. Servidor web (por ejemplo, Apache).
2. Servidor de base de datos MySQL.
3. PHP instalado en el servidor.

## Instalación

### 1. Descarga del Código Fuente

Descarga el código fuente del sistema desde el repositorio.

```bash
git clone https://github.com/tuusuario/sistema-de-informacion.git
```

### 2. Configuración del Entorno

- Coloca el código fuente en el directorio del servidor web (por ejemplo, `htdocs` en Apache).
- Crea una base de datos en MySQL para el sistema.

### 3. Configuración de la Base de Datos

- Importa el script SQL ubicado en la carpeta `db` para crear las tablas necesarias en la base de datos.

```bash
mysql -u tuusuario -p tunombredebasededatos < db/sistema_informacion.sql
```

### 4. Configuración del Archivo de Configuración

- Copia el archivo de configuración de ejemplo.

```bash
cp includes/config-sample.php includes/config.php
```

- Edita `includes/config.php` y proporciona la información correcta de la base de datos y otras configuraciones según sea necesario.

### 5. Configuración del Servidor de Correo Electrónico

- Si el sistema utiliza verificación de correo electrónico, asegúrate de configurar el servidor de correo electrónico en `includes/email-config.php`.

### Uso

Una vez completada la instalación, puedes acceder al sistema a través de tu navegador web:

```
http://localhost/sistema-de-informacion
```

### Acceso a Funcionalidades Principales

- **Registro de Usuario:**
  - Navega a la página de registro y sigue las instrucciones para registrar un nuevo usuario.

- **Inicio de Sesión:**
  - Después de registrarte, accede al sistema utilizando tus credenciales.

- **Gestión de Perfil:**
  - Desde el área de usuario, puedes acceder y modificar tu perfil.

- **Gestión de Avatares:**
  - Explora el módulo de avatares para cargar, eliminar y reemplazar tu foto de perfil.

- **Módulo de Pagos:**
  - Accede al módulo de pagos para ver productos comprados y realizar pagos parciales o totales.

- **Módulo de Pedidos:**
  - Utiliza el módulo de pedidos para realizar nuevas compras de productos.

### Notas Adicionales

- Este sistema es un ejemplo educativo y puede requerir ajustes adicionales para un entorno de producción real.
- Asegúrate de seguir las mejores prácticas de seguridad, como proteger las credenciales de la base de datos y mantener actualizado el sistema.

Estas instrucciones proporcionan una guía básica para la instalación y uso del Sistema de Información. Ajusta según las necesidades específicas de tu entorno y aplicación.
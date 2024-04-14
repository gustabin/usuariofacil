# Documentación Técnica: Sistema de Información - Arquitectura y Decisiones de Diseño

## Arquitectura General

El Sistema de Información está diseñado como una aplicación web modular basada en una arquitectura de cliente-servidor. Se han utilizado las siguientes tecnologías clave:

### Frontend:
- **HTML5, CSS3, Bootstrap:**
  - Para la estructura, estilo y diseño responsivo de las interfaces de usuario.
- **JavaScript, jQuery:**
  - Para la lógica del lado del cliente y la manipulación dinámica del DOM.
- **SweetAlert:**
  - Se ha integrado para mejorar la experiencia del usuario mediante notificaciones y mensajes interactivos.

### Backend:
- **PHP:**
  - Lenguaje de programación del lado del servidor para la implementación de la lógica de negocio y la interacción con la base de datos.
- **MySQL:**
  - Sistema de gestión de base de datos relacional para almacenar y recuperar datos.

### Arquitectura de Tres Capas:
- **Presentación (Frontend):**
  - Interfaz de usuario basada en HTML, CSS y JavaScript.
- **Lógica de Negocio (Backend):**
  - Implementada en PHP, maneja la lógica del negocio, validaciones y la interacción con la base de datos.
- **Persistencia de Datos (MySQL):**
  - Almacena y gestiona los datos del sistema.

### Comunicación entre Capas:
- La comunicación entre el frontend y el backend se realiza a través de solicitudes HTTP utilizando el patrón de arquitectura RESTful.
- Se implementan APIs bien definidas para garantizar una comunicación eficiente y segura entre las capas.

### Seguridad:
- Se aplican prácticas de seguridad, como la validación de entrada, la prevención de SQL injection y la gestión de sesiones para proteger contra posibles vulnerabilidades.

## Decisiones de Diseño

### Módulos del Sistema:

1. **Registro y Autenticación de Usuarios:**
   - Se implementa un módulo para el registro de usuarios que incluye verificación de correo electrónico.
   - La autenticación se gestiona mediante sesiones de usuario.

2. **Gestión de Perfil de Usuario:**
   - Permite a los usuarios ver y modificar su perfil, incluido el cambio de contraseña.

3. **Gestión de Avatares:**
   - Un módulo dedicado para la gestión de avatares que permite cargar, eliminar y reemplazar fotos de perfil.

4. **Módulo de Pagos:**
   - Los usuarios pueden ver los productos comprados y realizar pagos parciales o totales.
   - La gestión de la información de compra se realiza en el backend, mientras que los usuarios solo pueden realizar pagos.

5. **Módulo de Pedidos:**
   - Permite a los usuarios realizar pedidos de productos.

### Base de Datos:

1. **Tablas Relacionales:**
   - Se diseñan tablas en MySQL para almacenar información de usuarios, perfiles, pagos, pedidos, etc.
   - Se establecen relaciones clave entre las tablas para garantizar la integridad de los datos.

2. **Consultas Preparadas:**
   - Se utilizan consultas preparadas en PHP para prevenir inyecciones SQL y mejorar la seguridad.

### Patrón MVC (Modelo-Vista-Controlador):

- **Modelo (Backend - PHP):**
  - Encargado de la lógica de negocio y la interacción con la base de datos.
- **Vista (Frontend - HTML, JavaScript):**
  - Presenta la interfaz de usuario y maneja la interacción del usuario.
- **Controlador (JavaScript - jQuery):**
  - Maneja la lógica del lado del cliente, las interacciones del usuario y las solicitudes al backend.

### Pruebas de Integración:

- Se implementan pruebas de integración para asegurar la interoperabilidad de los módulos y la coherencia del flujo de trabajo.
- Las pruebas abarcan escenarios críticos y flujos de trabajo completos, garantizando la funcionalidad del sistema en su conjunto.

### Documentación y Colaboración:

- La documentación detallada se mantiene actualizada para facilitar la comprensión y colaboración entre miembros del equipo.
- Se utilizan estándares de codificación y se realizan revisiones de código para garantizar la coherencia y calidad del código fuente.

Este documento proporciona una visión general de la arquitectura y las decisiones de diseño del Sistema de Información, sirviendo como referencia para el equipo de desarrollo y otras partes interesadas.
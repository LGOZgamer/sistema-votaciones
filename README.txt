Sistema de Votaciones - PHP + MySQL

Ruta recomendada:
C:\xampp\htdocs\sistema_votaciones

URL:
http://localhost/sistema_votaciones/login.php

Instalación:
1. Copia la carpeta sistema_votaciones dentro de C:\xampp\htdocs.
2. Abre phpMyAdmin.
3. Importa el archivo db.sql.
4. Ingresa con cualquiera de estos usuarios:

Administrador:
Correo: admin@votaciones.com
Contraseña: admin123

Operador:
Correo: operador@votaciones.com
Contraseña: admin123

Digitador:
Correo: digitador@votaciones.com
Contraseña: admin123

Consulta:
Correo: consulta@votaciones.com
Contraseña: admin123

Cambios realizados sobre el proyecto base:
- Se eliminó el logo/imagen de Transmetro.
- Se agregó logo de votación en formato SVG.
- Se cambió el diseño a color azul.
- Se adaptaron módulos para Sistema de Votaciones:
  * Login
  * CRUD de usuarios
  * Roles
  * Gestión de votaciones
  * Gestión de mesas electorales
  * Gestión de candidatos
  * Registro de resultados
  * Consulta de resultados
  * Descarga CSV de resultados

Base de datos:
Nombre: votaciones_db
Archivo: db.sql

Nota:
Si tu carpeta se llama diferente, ajusta la URL según el nombre que copies en htdocs.

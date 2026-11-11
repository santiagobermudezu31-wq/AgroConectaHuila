# AgroConecta Huila

Marketplace agrícola de La Plata, Huila. Conecta productores con compradores.

## Stack

- PHP 8.2 · MVC · PDO
- MariaDB / InnoDB / utf8mb4
- Bootstrap 5 · Vanilla JS · Fetch API
- Apache + WampServer64

## Instalación

1. Copiar el proyecto en `C:\wamp64\www\AgroConectaHuila`.
2. Crear base `agroconecta_huila` importando `database/agroconecta.sql`.
3. Copiar `.env.example` a `.env` y ajustar credenciales.
4. Ejecutar `database/crear_admin.php` una vez y eliminarlo.
5. Activar `mod_rewrite` y `AllowOverride All` en Apache.
6. Acceder a `http://localhost/AgroConectaHuila`.

## Módulos

- Público: inicio, catálogo, detalle, registro, login
- Productor: dashboard, perfil, publicaciones, nueva, editar, retirar
- Admin: dashboard, productores, productos, categorías

## Seguridad

- password_hash / password_verify
- Sesiones seguras (HttpOnly, SameSite)
- CSRF en formularios
- Validación con PDO (prepared statements)
- Roles: administrador / productor
- Uploads con validación MIME y nombres aleatorios

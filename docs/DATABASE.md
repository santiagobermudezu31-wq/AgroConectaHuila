# Base de datos

Motor: InnoDB · Charset: utf8mb4 · Collation: utf8mb4_unicode_ci

## Tablas

- usuarios
- productores
- categorias
- productos
- imagenes_productos
- historial_publicaciones
- recuperacion_password
- aceptacion_politicas
- configuraciones

## Relaciones clave

- usuarios 1—1 productores
- productores 1—N productos
- categorias 1—N productos
- productos 1—N imagenes_productos
- productos 1—N historial_publicaciones

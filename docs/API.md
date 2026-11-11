# API REST

## Auth

- POST /api/auth/register { nombre_usuario, correo, password, password_confirmacion, nombre_productor, zona_vereda, acepta_politica }
- POST /api/auth/login { identificador, password }
- POST /api/auth/logout
- GET /api/auth/me

## Productos

- GET /api/products?q&categoria&precio_min&precio_max&orden&page
- GET /api/products/{id}

## Categorías

- GET /api/categories
- POST /api/categories (admin)
- PUT /api/categories/{id} (admin)
- DELETE /api/categories/{id} (admin)

## Admin

- GET /api/admin/dashboard (admin)

## Formato

{ "success": true, "message": "...", "data": ... }

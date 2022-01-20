# Test Bamba Backend

## Laravel Stack

This repo contains a frontend and bakend layouts for a laravel breeze  
Contains:
- Laravel 8
- Tailwind
- Livewire
- Alpine JS

Helpers: file autoload helper on `app\helpers.php`

Se uso como backend un clon del repositorio personal [Blockpc](https://github.com/blockpc/blockpc-with-backend)

## Test

> La prueba consiste en realizar la funcionalidad necesaria para alta de orden de compra, para ello se
propone el siguiente diagrama, a partir de estas entidades desarrollar los puntos de la siguiente
página.

Se cambio el nombre de la tabla propuesta __order_items__ por __order_product__ para seguir la conveción de laravel.

### Generales

Correr el comando `php artisan migrate --seed` o `php artisan migrate:fresh --seed` para ejecutar los seeder de usuarios, roles y permisos

Todos los usuarios registrados desde el frontend tendran el rol _user_

Se agregaron los siguientes permisos, para mantener la consistencia del backend:  

- product_list, product_create, product_update, product_delete, product_restore
- order_list, order_create, order_update, order_delete, order_restore

El cargo _sudo_ tiene permiso de super usuario.
El cargo _admin_ tiene permisos de administrador.
El cargo _user_ tiene permisos restringidos

Se pueden revisar los usuarios (y sus claves) por defecto desde el seeder _UsersSeeder_
Se pueden revisar los cargos y permisos por defecto desde el seeder _RoleAndPermissionsSeeder_

### Test para Productos

Se encuentran en _tests/Products_

Correr el comando `php artisan test --testsuite=Products`
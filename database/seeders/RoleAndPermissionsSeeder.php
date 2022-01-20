<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* Role for developer */
        $role_sudo = Role::create([
            'name' => 'sudo',
            'display_name' => 'Super Administrador',
            'description' => 'Usuario con acceso total',
        ]);

		/* Role for your admin/client/boss */
        $role_admin = Role::create([
            'name' => 'admin',
            'display_name' => 'Administrador',
            'description' => 'Usuario con acceso general',
        ]);

		/* Role for 'user' app */
        $role_user = Role::create([
            'name' => 'user',
            'display_name' => 'Usuario',
            'description' => 'Usuario con acceso restringido',
        ]);

        /**
         * Permissions
         */
        $super_admin    = Permission::create([
            'name' => 'super admin', 
            'display_name' => 'Super usuario',
            'description' => 'Permiso del desarrollador. Necesario para evaluar el funcionamiento del sistema y correción de errores',
            'key' => 'sudo',
        ]);

        $settings_control = Permission::create([
            'name' => 'settings control', 
            'display_name' => 'Control Configuración',
            'description' => 'Controla el acceso a la configuración del sistema',
            'key' => 'settings',
        ]);

        $user_list     = Permission::create([
            'name' => 'user list', 
            'display_name' => 'Listado de Usuarios',
            'description' => 'Permite acceder al listado de usuarios',
            'key' => 'users',
        ]);
        $user_create    = Permission::create([
            'name' => 'user create', 
            'display_name' => 'Crear Usuarios',
            'description' => 'Permite crear un nuevo usuario',
            'key' => 'users',
        ]);
        $user_update    = Permission::create([
            'name' => 'user update', 
            'display_name' => 'Actualizar Usuarios',
            'description' => 'Permite actualizar la información de un usuario',
            'key' => 'users',
        ]);
        $user_delete    = Permission::create([
            'name' => 'user delete', 
            'display_name' => 'Eliminar Usuarios',
            'description' => 'Permite eliminar un usuario',
            'key' => 'users',
        ]);
        $user_restore   = Permission::create([
            'name' => 'user restore', 
            'display_name' => 'Restaurar Usuario',
            'description' => 'Permite restaurar un usuario eliminado anteriormente',
            'key' => 'users',
        ]);

        $role_list      = Permission::create([
            'name' => 'role list', 
            'display_name' => 'Listado de Cargos',
            'description' => 'Permite acceder al listado de cargos',
            'key' => 'roles',
        ]);
        $role_create    = Permission::create([
            'name' => 'role create', 
            'display_name' => 'Crear Cargos',
            'description' => 'Permite crear un cargo',
            'key' => 'roles',
        ]);
        $role_update    = Permission::create([
            'name' => 'role update', 
            'display_name' => 'Actualizar Cargos',
            'description' => 'Permite actualizar un cargo',
            'key' => 'roles',
        ]);
        $role_delete    = Permission::create([
            'name' => 'role delete', 
            'display_name' => 'Eliminar Cargos',
            'description' => 'Permite eliminar un cargo',
            'key' => 'roles',
        ]);
        $role_restore   = Permission::create([
            'name' => 'role restore', 
            'display_name' => 'Restaurar Cargo',
            'description' => 'Permite restaurar un cargo eliminado anteriormente',
            'key' => 'roles',
        ]);

        $permission_list = Permission::create([
            'name' => 'permission list', 
            'display_name' => 'Listado de Permisos',
            'description' => 'Permite el acceso a la lista de permisos',
            'key' => 'permissions',
        ]);

        /* Test Bamba */
        $product_list      = Permission::create([
            'name' => 'product list', 
            'display_name' => 'Listado de Productos',
            'description' => 'Permite acceder al listado de productos',
            'key' => 'products',
        ]);
        $product_create    = Permission::create([
            'name' => 'product create', 
            'display_name' => 'Crear Productos',
            'description' => 'Permite crear un producto',
            'key' => 'products',
        ]);
        $product_update    = Permission::create([
            'name' => 'product update', 
            'display_name' => 'Actualizar Productos',
            'description' => 'Permite actualizar un producto',
            'key' => 'products',
        ]);
        $product_delete    = Permission::create([
            'name' => 'product delete', 
            'display_name' => 'Eliminar Productos',
            'description' => 'Permite eliminar un producto',
            'key' => 'products',
        ]);
        $product_restore   = Permission::create([
            'name' => 'product restore', 
            'display_name' => 'Restaurar Producto',
            'description' => 'Permite restaurar un producto eliminado anteriormente',
            'key' => 'products',
        ]);
        
        $order_list      = Permission::create([
            'name' => 'order list', 
            'display_name' => 'Listado de Pedidos',
            'description' => 'Permite acceder al listado de pedidos',
            'key' => 'orders',
        ]);
        $order_create    = Permission::create([
            'name' => 'order create', 
            'display_name' => 'Crear Pedidos',
            'description' => 'Permite crear un pedido',
            'key' => 'orders',
        ]);
        $order_update    = Permission::create([
            'name' => 'order update', 
            'display_name' => 'Actualizar Pedidos',
            'description' => 'Permite actualizar un pedido',
            'key' => 'orders',
        ]);
        $order_delete    = Permission::create([
            'name' => 'order delete', 
            'display_name' => 'Eliminar Pedidos',
            'description' => 'Permite eliminar un pedido',
            'key' => 'orders',
        ]);
        $order_restore   = Permission::create([
            'name' => 'order restore', 
            'display_name' => 'Restaurar Pedido',
            'description' => 'Permite restaurar un pedido eliminado anteriormente',
            'key' => 'orders',
        ]);

        /**
         * Assign permissions to role
         */
        $role_sudo->givePermissionTo($super_admin);
        $role_admin->syncPermissions([
            $permission_list,
            $user_list, $user_create, $user_update, $user_delete, $user_restore,
            $role_list, $role_create, $role_update, $role_delete, $role_restore,
            // Test Bamba
            $product_list, $product_create, $product_update, $product_delete, $product_restore,
            $order_list, $order_create, $order_update, $order_delete, $order_restore
        ]);
        $role_user->syncPermissions([
            $user_list,
            $role_list,
            $permission_list, 
            // Test Bamba
            $product_list,
            $order_list,
        ]);
    }
}
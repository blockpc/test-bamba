<?php

declare(strict_types=1);

namespace Tests;

use App\Models\Profile;
use App\Models\User;
use Blockpc\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Blockpc\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class TestBase extends TestCase
{
    use RefreshDatabase, WithFaker;
    
    protected Role $role_sudo;
    protected Role $role_admin;
    protected Role $role_user;

    protected Permission $super_admin;
    protected Permission $permission_list;
    protected Permission $user_list;
    protected Permission $role_list;

    protected User $sudo;
    protected User $admin;
    protected User $user;

    /* Test Bamba */
    protected Permission $product_list;
    protected Permission $product_create;
    protected Permission $product_update;
    protected Permission $product_delete;
    protected Permission $product_restore;
    
    protected function setUp():void
    {
        parent::setUp();
        $this->app->make(PermissionRegistrar::class)->registerPermissions();

        $this->assigns();
    }

    protected function assigns()
    {
        $this->role_sudo = $this->new_role('sudo', 'Super Administrador');
        $this->role_admin = $this->new_role('admin', 'Administrador');
        $this->role_user = $this->new_role('user', 'Usuario');

        $this->super_admin = $this->new_permission('super admin');
        $this->permission_list = $this->new_permission('permission list');
        $this->user_list = $this->new_permission('user list');
        $this->role_list = $this->new_permission('role list');

        /* test Bamba */
        $this->product_list = $this->new_permission('product list');
        $this->product_create = $this->new_permission('product create');
        $this->product_update = $this->new_permission('product update');
        $this->product_delete = $this->new_permission('product delete');
        $this->product_restore = $this->new_permission('product restore');

        $this->role_sudo->givePermissionTo([
            $this->super_admin, 
        ]);

        $this->role_admin->givePermissionTo([
            $this->permission_list, 
            $this->user_list,
            $this->role_list,
            /* test Bamba */
            $this->product_list, $this->product_create, $this->product_update, $this->product_delete, $this->product_restore,
        ]);

        $this->role_user->givePermissionTo([
            $this->permission_list, 
            /* test Bamba */
            $this->product_list, 
        ]);

        $this->sudo = $this->new_user([
            'name' => 'sudo',
            'email' => 'sudo@mail.com',
        ], $this->role_sudo);

        $this->admin = $this->new_user([
            'name' => 'admin',
            'email' => 'admin@mail.com',
        ], $this->role_admin);

        $this->user = $this->new_user([
            'name' => 'user',
            'email' => 'user@mail.com',
        ], $this->role_user);
    }

    protected function new_role(string $name, string $display_name)
    {
        return Role::create([
            'name' => $name,
            'display_name' => $display_name,
        ]);
    }

    protected function new_permission(string $name)
    {
        return Permission::create([
            'name' => $name, 
            'display_name' => "Listado de {$name}",
            'description' => 'Permite acceder al listado de documentos',
            'key' => 'key',
        ]);
    }

    protected function new_user(array $attributes = [], $role = null)
    {
        $user = User::factory()->create($attributes);
        $user->assignRole($role ?? $this->role_user);
        Profile::factory()->forUser($user)->create();
        return $user;
    }
}
<?php

namespace App\Http\Livewire\System\Permissions;

use App\Models\User;
use Blockpc\Models\Permission;
use Livewire\Component;

class Table extends Component
{
    public User $auth;

    public $search = "";

    private $solo_super_admins = [
        'super admin', 
        'jobs control', 
        'permission control'
    ];

    public function mount()
    {
        $this->auth = current_user();
    }

    public function getPermissionsProperty()
    {
        if ( current_user()->hasRole('sudo') ) {
            return Permission::all();
        }
        return $this->auth->getAllPermissions();
    }

    public function render()
    {
        $list_permissions = [];
        foreach($this->permissions->groupBy('key') as $group => $collection) {
            $list_permissions[$group] = [];
            foreach($collection as $permission) {
                $list_permissions[$group][$permission->id] = $permission;
            }
        }
        return view('livewire.system.permissions.table', [
            'permissions' => $list_permissions,
        ]);
    }

    public function clean()
    {
        $this->reset('search', 'paginate');
    }
}

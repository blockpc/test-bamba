<?php

namespace App\Http\Livewire\System\Roles;

use App\Models\User;
use Blockpc\Models\Permission;
use Blockpc\Models\Role;
use Blockpc\Traits\AlertBrowserEvent;
use Illuminate\Validation\Rule;
use Livewire\Component;

class FormRoles extends Component
{
    use AlertBrowserEvent;
    
    public User $auth;
    public Role $role;

    public $step = 1;
    public $name;
    public $display_name;
    public $description;

    public $type = 'new';
    public $title_loading = 'Creando Cargo...';

    public array $user_permissions;

    private $solo_super_admins = [
        'super admin', 
    ];

    protected $listeners = [
        'cancel-form-user' => 'cancel',
        'assign'
    ];

    public function mount()
    {
        $this->auth = current_user();
        $this->clear();
    }

    public function render()
    {
        $permissions = $this->permissions();
        $list_permissions = [];
        foreach($permissions->groupBy('key') as $group => $collection) {
            $list_permissions[$group] = [];
            foreach($collection as $permission) {
                $list_permissions[$group][$permission->id] = $permission;
            }
        }
        return view('livewire.system.roles.form-roles', [
            'permissions' => $list_permissions,
        ]);
    }

    public function assign(Role $role)
    {
        $this->role = $role;
        $this->step = 1;
        $this->name = $this->role->name;
        $this->display_name = $this->role->display_name;
        $this->description = $this->role->description;
        $this->type = 'edit';
        $this->title_loading = "Editando cargo...";
        $this->user_permissions = $this->role->permissions->pluck('name', 'id')->all();
    }

    public function save()
    {
        if ( $this->step == 3) {
            $this->role->name = $this->name;
            $this->role->display_name = $this->display_name;
            $this->role->description = $this->description;
            $this->role->save();
            $this->role->syncPermissions($this->user_permissions);

            $message = 'El Cargo ha sido editado correctamente';
            $title = 'Cargo Editado';
            if ( $this->type == 'new' ) {
                $message = 'Cargo registrado correctamente';
                $title = 'Nuevo Cargo';
            }

            $this->emitTo('system.roles.table', 'update-table');
            $this->dispatchBrowserEvent('table-roles');
            $this->alert($message, $title);
            $this->clear();
        }
    }

    protected function rules()
    {
        if ( $this->step == 1) {
            $unique_name = !$this->role->exists ? Rule::unique('roles', 'name') : Rule::unique('roles', 'name')->ignore($this->role);
            return [
                'name' => ['required', 'alpha_num', 'max:32', $unique_name],
                'display_name' => ['required', 'string', 'max:64'],
                'description' => ['nullable', 'string', 'max:255'],
            ];
        }
        if ( $this->step == 2) {
            return [
                'user_permissions' => 'required|array',
                'user_permissions.*' => [
                    'required', 
                    Rule::notIn($this->solo_super_admins), 
                    Rule::exists('permissions', 'name')
                ],
            ];
        }
    }

    protected $validationAttributes = [
        'name' => 'alias',
        'display_name' => 'nombre',
        'description' => 'descripción',
    ];

    protected $messages = [
        'user_permissions.required' => 'Se debe elegir al menos un permiso.',
        'user_permissions.*.in' => 'El cargo seleccionado no esta permitido.',
        'user_permissions.*.exists' => 'El cargo seleccionado no existe.',
    ];

    public function cancel()
    {
        if ( !$this->role->exists ) {
            $this->clear();
        }
        $this->resetErrorBag();
        $this->dispatchBrowserEvent('table-roles');
    }

    private function clear()
    {
        $this->role = new Role;
        $this->step = 1;
        $this->name = "";
        $this->display_name = "";
        $this->description = "";
        $this->type = 'new';
        $this->title_loading = "Creando cargo...";
        $this->user_permissions = [];
    }

    public function step_add()
    {
        $this->resetErrorBag();
        $this->validate();
        $this->step++;
    }

    public function step_minus()
    {
        $this->resetErrorBag();
        $this->step--;
    }

    protected function permissions()
    {
        $permissions = $this->auth->hasRole('sudo') 
            ? Permission::all() 
            : $this->auth->getAllPermissions();
        return $permissions;
    }

    public function final_list()
    {
        $list = Permission::whereIn('name', $this->user_permissions)->get();
        return $list->pluck('display_name')->implode(', ');
    }
}

<?php

namespace App\Http\Livewire\System\Roles;

use App\Models\User;
use Blockpc\Models\Role;
use Blockpc\Traits\AlertBrowserEvent;
use Blockpc\Traits\WithSorting;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination, WithSorting, AlertBrowserEvent;

    protected $listeners = [
        'update-table' => '$refresh',
    ];

    public User $auth;

    public $search = "";
    public $paginate = 10;
    //public $roles_deleted = 0;

    public $roles_base = Role::ROLES_NOT_DELETES;

    public function mount()
    {
        $this->auth = current_user();
        $this->sortField = 'created_at';
    }

    public function getRolesProperty()
    {
        $roles = Role::withCount('users');

        if ( !$this->auth->hasRole('sudo') ) {
            $roles->whereNotIn('name', ['sudo']);
        }

        return $roles->whereLike(['name', 'display_name'], $this->search)
            ->latest()->paginate($this->paginate);
    }

    public function render()
    {
        return view('livewire.system.roles.table', [
            'roles' => $this->roles,
        ]);
    }

    public function clean()
    {
        $this->reset('search', 'paginate');
    }

    // public function eliminated()
    // {
    //     $this->roles_deleted = !$this->roles_deleted;
    // }

    public function delete(Role $role)
    {
        if ( in_array($role->name, $this->roles_base) ) {
            $this->addError('delete_role', 'No se puede borrar un cargo base');
            return;
        }
        $name = $role->name;
        if ( $count = $role->hasUsers() ) {
            $this->addError('delete_role', "No se puede borrar el cargo <b>{$name}</b>, pues aun esta asociado a <b>{$count}</b> usuarios");
            return;
        }
        $role->delete();
        $this->alert("El cargo <b>{$name}</b> ha sido eliminado del sistema", 'Eliminar Cargo');
    }

    public function restore(int $id)
    {
        $this->addError('delete_role', 'Restaurar Cargo no esta habilitado en la configración');
        return;
    }
}

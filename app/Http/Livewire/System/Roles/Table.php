<?php

namespace App\Http\Livewire\System\Roles;

use App\Models\User;
use Blockpc\Models\Role;
use Blockpc\Traits\WithSorting;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination, WithSorting;

    protected $listeners = [
        'update-table' => '$refresh',
    ];

    public User $auth;

    public $search = "";
    public $paginate = 10;
    public $roles_deleted = 0;

    public $roles_base = Role::ROLES_NOT_DELETES;

    public function mount()
    {
        $this->auth = current_user();
        $this->sortField = 'created_at';
    }

    public function getRolesProperty()
    {
        $roles = Role::withCount('users');

        if ( $this->auth->hasRole('sudo') ) {
            return $roles->whereLike(['name', 'display_name'], $this->search)
                ->latest()->paginate($this->paginate);
        }

        return $roles->whereNotIn('name', ['sudo'])->whereLike(['name', 'display_name'], $this->search)
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

    public function eliminated()
    {
        $this->roles_deleted = !$this->roles_deleted;
    }
}

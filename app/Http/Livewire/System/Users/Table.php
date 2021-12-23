<?php

namespace App\Http\Livewire\System\Users;

use App\Models\User;
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
    public $users_deleted = 0;

    public function mount()
    {
        $this->auth = current_user();
        $this->sortField = 'created_at';
    }

    public function getUsersProperty()
    {
        $users = User::with('roles');

        if ( $this->users_deleted ) {
            $users->onlyTrashed();
        } else {
            $users->allowed();
        }

        $users->whereLike(['name','email', 'profile.firstname', 'profile.lastname'], $this->search)
            ->orderBy($this->sortField, $this->sortDirection);

        return $users->latest()->paginate($this->paginate);
    }

    public function render()
    {
        return view('livewire.system.users.table', [
            'users' => $this->users,
        ]);
    }

    public function clean()
    {
        $this->search = "";
        $this->paginate = 10;
        $this->users_deleted = 0;
    }

    public function delete(User $user)
    {
        $name = $user->name;
        $user->delete();
        session()->flash('delete', "Un usuario <b>{$name}</b> fue eliminado.");
    }

    public function restore(int $id)
    {
        $user = User::withTrashed()->where('id', $id)->first();
        $user->restore();
        session()->flash('restore', "Un usuario <b>{$user->name}</b> fue restaurado.");
    }

    public function eliminated()
    {
        $this->users_deleted = !$this->users_deleted;
    }
}

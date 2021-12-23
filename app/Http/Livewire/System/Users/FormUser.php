<?php

namespace App\Http\Livewire\System\Users;

use App\Models\Profile;
use App\Models\User;
use Blockpc\Events\ReSendLinkToChangePasswordEvent;
use Blockpc\Events\SendEmailForNewUserEvent;
use Blockpc\Models\Role;
use Blockpc\Traits\AlertBrowserEvent;
use Blockpc\Validators\IsInteger;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role as ModelsRole;

class FormUser extends Component
{
    use AlertBrowserEvent;

    protected $listeners = [
        'cancel-form-user' => 'cancel',
        'assign'
    ];

    public User $auth;
    
    public User $user;
    public Profile $profile;
    public $setting;
    public $role;

    public $type = 'new';

    public $title_loading = "Creando usuario...";

    public function mount()
    {
        $this->auth = current_user();
        $this->clear();
    }

    public function getRolesProperty()
    {
        if ( !$this->auth->hasRole('sudo') ) {
            return Role::whereNotIn('name', ['sudo'])->pluck('display_name', 'id');
        }
        return Role::all()->pluck('display_name', 'id');
    }
    
    public function render()
    {
        return view('livewire.system.users.form-user', [
            'roles' => $this->roles,
        ]);
    }

    public function save()
    {
        $this->validate();
        $password = Str::random(8);
        $this->user->password = Hash::make($password);
        $this->user->save();
        $this->profile->user()->associate($this->user);
        $this->profile->save();
        $this->user->syncRoles($this->role);

        $message = 'El Usuario ha sido editado correctamente';
        $title = 'Usuario Editado';
        if ( $this->type == 'new' ) {
            SendEmailForNewUserEvent::dispatch($this->user);
            $message = 'Usuario registrado correctamente';
            $title = 'Nuevo Usuario';
        }

        $this->emitTo('system.users.table', 'update-table');
        $this->dispatchBrowserEvent('table-users');
        $this->alert($message, $title);
    }

    protected function rules()
    {
        $unique_name = !$this->user->exists ? Rule::unique('users', 'name') : Rule::unique('users', 'name')->ignore($this->user);
        $unique_email = !$this->user->exists ? Rule::unique('users', 'email') : Rule::unique('users', 'email')->ignore($this->user);
        return [
            'user.name' => ['required', 'alpha_num', 'max:64', $unique_name],
            'user.email' => ['required', 'email', 'max:64', $unique_email],
            'role' => ['required', 'integer', Rule::exists('roles', 'id')],
            'profile.firstname' => ['nullable', 'max:64'],
            'profile.lastname' => ['nullable', 'max:64'],
            'profile.phone' => ['nullable', 'regex:/^(\+[\d]{1,2}+(\s)?)?+[\d]{8,10}$/', 'min:8', 'max:15'],
        ];
    }

    public function cancel()
    {
        $this->clear();
        $this->resetErrorBag();
        $this->dispatchBrowserEvent('table-users');
    }

    private function clear()
    {
        $this->user = new User;
        $this->profile = new Profile;
        $this->profile->firstname = '';
        $this->profile->lastname = '';
        $this->profile->phone = '';
        $this->role = '';
        $this->type = 'new';
        $this->title_loading = "Creando usuario...";
    }

    public function assign(User $user)
    {
        $this->user = $user;
        $this->profile = $user->profile;
        $this->role = $user->role_id;
        $this->type = 'edit';
        $this->title_loading = "Editando usuario...";
    }

    public function resend()
    {
        if ( $this->user->exists && $name = $this->user->name ) {
            $this->title_loading = "Enviando link...";

            ReSendLinkToChangePasswordEvent::dispatch($this->user);

            $this->clear();
            $this->dispatchBrowserEvent('table-users');
            $this->alert(
                "Se ha enviado un link al usuario {$name} para cambiar la contraseña", 
                'Cambio de Contraseña'
            );
            $this->emitTo('system.users.table', 'update-table');
        }
    }
}

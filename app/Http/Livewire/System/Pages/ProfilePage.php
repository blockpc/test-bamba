<?php

namespace App\Http\Livewire\System\Pages;

use App\Models\Profile;
use App\Models\User;
use Blockpc\Traits\AlertBrowserEvent;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ProfilePage extends Component
{
    use AlertBrowserEvent, WithFileUploads;
    
    public User $auth;
    public Profile $profile;

    public $password;
    public $password_confirmation;
    public $photo;

    public function mount()
    {
        $this->auth = current_user();
        $this->profile = current_user()->profile;
    }

    public function render()
    {
        return view('livewire.system.pages.profile-page');
    }

    public function save()
    {
        $this->validate();
        if ( $this->password ) {
            $this->auth->password = hash::make($this->password);
        }
        $this->auth->save();
        if ( $this->photo ) {
            $name = Str::slug(mb_strtolower($this->auth->name));
            $extension = $this->photo->extension();
            if ( $this->auth->profile->image && file_exists(public_path($this->auth->profile->image)) ) {
                unlink(public_path($this->auth->profile->image));
            }

            $img = Image::make($this->photo->getRealPath())
                    ->encode('jpg', 65)
                    ->fit(400, null, function ($constrain) {
                        $constrain->aspectRatio();
                        $constrain->upsize();
                    });
            $img->stream(); // <-- Key point

            $path = "photo_profiles/{$name}.{$extension}";
            Storage::disk('public')->put($path, $img);
            
            $this->profile->image = "/storage/{$path}";
        }
        $this->profile->save();
        $this->auth->refresh();
        $this->alert('Tu perfil de usuario ha sido actualizado', 'Perfil de Usuario');
    }

    /**
     * @param \Livewire\TemporaryUploadedFile $value
     */
    public function updatedPhoto($value)
    {
        $validator = Validator::make(
            ['photo' => $this->photo],
            ['photo' => ['nullable', 'image', 'mimes:jpg,png', 'max:1024']],
        );
    
        if ($validator->fails()) {
            $this->reset('photo');
            $this->setErrorBag($validator->getMessageBag());
        }
    }

    protected function rules()
    {
        $unique_name = Rule::unique('users', 'name')->ignore($this->auth);
        $unique_email = Rule::unique('users', 'email')->ignore($this->auth);
        return [
            'auth.name' => ['required', 'alpha_num', 'max:64', $unique_name],
            'auth.email' => ['required', 'email', 'max:64', $unique_email],
            'password' => ['nullable', 'confirmed', Password::default()],
            'profile.firstname' => ['nullable', 'max:64'],
            'profile.lastname' => ['nullable', 'max:64'],
            'profile.phone' => ['nullable', 'regex:/^(\+[\d]{1,2}+(\s)?)?+[\d]{8,10}$/', 'min:8', 'max:15'],
        ];
    }

    protected $validationAttributes = [
        'name' => 'Usuario',
        'firstname' => 'Nombres',
        'lastname' => 'Apellidos',
        'phone' => 'teléfono',
    ];

    public function cancel()
    {
        $this->user = current_user();
        $this->profile = current_user()->profile;
        $this->password = "";
        $this->password_confirmation = "";
        $this->photo = null;
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function generate()
    {
        $this->password = $this->password_confirmation = Str::random(12);
    }
}

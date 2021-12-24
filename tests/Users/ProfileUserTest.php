<?php

declare(strict_types=1);

namespace Tests\Users;

use App\Http\Livewire\System\Pages\ProfilePage;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestBase;

final class ProfileUserTest extends TestBase
{
    protected function setUp(): void 
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    /** @test */
    public function user_can_access_to_profile_user_page()
    {
        $this->actingAs($this->user);
        $response = $this->get(route('profile'));

        $response->assertStatus(200)
            ->assertViewIs('system.pages.profile')
            ->assertSeeLivewire('system.pages.profile-page');
    }

    /** @test */
    public function check_vars_on_profile_form()
    {
        Livewire::actingAs($this->user)
            ->test(ProfilePage::class)
            ->assertPropertyWired('auth.name')
            ->assertPropertyWired('auth.email')
            ->assertPropertyWired('password')
            ->assertPropertyWired('password_confirmation')
            ->assertPropertyWired('profile.firstname')
            ->assertPropertyWired('profile.lastname')
            ->assertPropertyWired('profile.phone')
            ->assertPropertyWired('photo')
            ->assertMethodWiredToForm('save');
    }

    /** 
     * @test 
     * @dataProvider validationRules
     */
    public function check_errors_save_profile_user($field, $value, $rule)
    {
        Livewire::actingAs($this->user)
            ->test(ProfilePage::class)
            ->set($field, $value)
            ->call('save')
            ->assertHasErrors([$field => $rule]);
    }

    /** @test */
    public function valid_error_new_password()
    {
        Livewire::actingAs($this->user)
            ->test(ProfilePage::class)
            ->set('password', '123qwerty')
            ->set('password_confirmation', '123qwert')
            ->call('save')
            ->assertHasErrors(['password' => 'confirmed']);
    }

    public function validationRules()
    {
        return [
            'the user name is required' => ['auth.name', null, 'required'],
            'the user name must be contains only letters and numbers' => ['auth.name', 'un nombre', 'alpha_num'],
            'the user name is too long' => ['auth.name', str_repeat('*', 65), 'max'],
            'the user name exists' => ['auth.name', 'sudo', 'unique'],
            'the user name is required' => ['auth.email', null, 'required'],
            'the user name is not valid' => ['auth.email', 'un email', 'email'],
            'the user email is too long' => ['auth.email', str_repeat('*', 65), 'max'],
            'the user email exists' => ['auth.email', 'sudo@mail.com', 'unique'],
            'the profile firstname is too long' => ['profile.firstname', str_repeat('*', 65), 'max'],
            'the profile lastname is too long' => ['profile.lastname', str_repeat('*', 65), 'max'],
            'the profile phone is too short' => ['profile.phone', str_repeat('*', 7), 'min'],
            'the profile phone is too long' => ['profile.phone', str_repeat('*', 16), 'max'],
            'the profile phone is not valid' => ['profile.phone', 'un.numero.123', 'regex'],
        ];
    }

    /** @test */
    public function user_can_update_their_profile()
    {
        $this->assertDatabaseHas('users', [
            'name' => 'user',
            'email' => 'user@mail.com'
        ]);

        Livewire::actingAs($this->user)
            ->test(ProfilePage::class)
            ->set('auth.name', 'other')
            ->set('auth.email', 'other@mail.com')
            ->set('password', '123qwerty')
            ->set('password_confirmation', '123qwerty')
            ->set('profile.firstname', 'Jhon')
            ->set('profile.lastname', 'Doe')
            ->set('profile.phone', '123456789')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('users', [
            'name' => 'other',
            'email' => 'other@mail.com',
        ]);

        $this->assertDatabaseHas('profiles', [
            'firstname' => 'Jhon',
            'lastname' => 'Doe',
            'phone' => '123456789',
            'user_id' => $this->user->id,
        ]);
    }

    /** @test */
    public function valid_photo_is_not_valid()
    {
        Storage::fake('public');
        $image = UploadedFile::fake()->image('avatar.gif', 200, 400)->size(1050);

        $livewire = Livewire::actingAs($this->user)
            ->test(ProfilePage::class)
            ->set('photo', $image)
            ->call('save')
            ->assertSessionHasNoErrors();
        
        $photo = $livewire->get('photo');
        $this->assertNull($photo);
    }

    /** @test */
    public function can_upload_photo()
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->image('perfil.jpg');
    
        Livewire::actingAs($this->user)
            ->test(ProfilePage::class)
            ->set('photo', $file)
            ->call('save');

        $this->assertDatabaseHas('profiles', [
            'firstname' => $this->user->profile->firstname,
            'lastname' => $this->user->profile->lastname,
            'image' => "/storage/photo_profiles/{$this->user->name}.jpg",
            'user_id' => $this->user->id
        ]);
    
        Storage::disk('public')->assertExists("photo_profiles/{$this->user->name}.jpg");
    }

    /** @test */
    public function can_user_generate_password()
    {
        $livewire = Livewire::actingAs($this->user)
            ->test(ProfilePage::class)
            ->call('generate')
            ->call('save')
            ->assertSessionHasNoErrors();
        
        $password = $livewire->get('password');
    }
}
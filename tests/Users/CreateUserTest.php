<?php

declare(strict_types=1);

namespace Tests\Users;

use App\Http\Livewire\System\Users\FormUser;
use App\Models\Profile;
use App\Models\User;
use Blockpc\Events\SendEmailForNewUserEvent;
use Blockpc\Events\ReSendLinkToChangePasswordEvent;
use Carbon\Carbon;
use Illuminate\Support\Facades\Event;
use Livewire\Livewire;
use Tests\TestBase;

final class CreateUserTest extends TestBase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    /** @test */
    public function sudo_can_to_see_form_to_create_users_central()
    {
        Livewire::actingAs($this->sudo)
            ->test(FormUser::class)
            ->assertPropertyWired('user.name')
            ->assertPropertyWired('user.email')
            ->assertPropertyWired('role')
            ->assertPropertyWired('profile.firstname')
            ->assertPropertyWired('profile.lastname')
            ->assertPropertyWired('profile.phone')
            ->assertMethodWiredToForm('save');
    }

    /** 
     * @test 
     * @dataProvider validationRules
     */
    public function check_errors_create_user($field, $value, $rule)
    {
        Livewire::actingAs($this->sudo)
            ->test(FormUser::class)
            ->set($field, $value)
            ->call('save')
            ->assertHasErrors([$field => $rule]);
    }

    public function validationRules()
    {
        return [
            'user name is null' => ['user.name', null, 'required'],
            'user name only alpha and numbers' => ['user.name', 'alpha num', 'alpha_num'],
            'user name is too long' => ['user.name', str_repeat('*', 65), 'max'],
            'user name is not unique' => ['user.name', 'sudo', 'unique'],
            'user email is null' => ['user.email', null, 'required'],
            'user email is invalid' => ['user.email', 'this is not an email', 'email'],
            'user email is not unique' => ['user.email', 'sudo@mail.com', 'unique'],
            'user email is too long' => ['user.email', str_repeat('*', 65), 'max'],
            'user profile firstname is too long' => ['profile.firstname', str_repeat('*', 65), 'max'],
            'user profile lastname is too long' => ['profile.lastname', str_repeat('*', 65), 'max'],
            'user profile phone not valid' => ['profile.phone', '+56 9 696 #969', 'regex'],
            'user profile phone is too long' => ['profile.phone', '+56 9 696969231213', 'max'],
            'role is empty' => ['role', '', 'required'],
            'role is not valid' => ['role', 'as', 'integer'],
            'role not exusts' => ['role', 100, 'exists'],
        ];
    }

    /** @test */
    public function sudo_can_create_a_new_user()
    {
        $this->assertDatabaseHas('roles', [
            'id' => 1,
            'name' => 'sudo'
        ]);

        $livewire = Livewire::actingAs($this->sudo)
            ->test(FormUser::class)
            ->set('user.name', 'usuario')
            ->set('user.email', 'usuario@mail.com')
            ->set('role', 1)
            ->set('profile.firstname', 'Jhon')
            ->set('profile.lastname', 'Doe')
            ->set('profile.phone', '+56 961881674')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('users', [
            'name' => 'usuario',
            'email' => 'usuario@mail.com',
        ]);
    }

    /** @test */
    public function emit_event_after_create_user()
    {
        Event::fake([SendEmailForNewUserEvent::class]);

        Livewire::actingAs($this->sudo)
            ->test(FormUser::class)
            ->set('user.name', 'usuario')
            ->set('user.email', 'usuario@mail.com')
            ->set('role', 1)
            ->set('profile.firstname', 'Jhon')
            ->set('profile.lastname', 'Doe')
            ->set('profile.phone', '+56 961881674')
            ->call('save')
            ->assertHasNoErrors();

        Event::assertDispatched(SendEmailForNewUserEvent::class);
    }

    /** @test */
    public function can_resend_email_to_change_password()
    {
        Event::fake([ReSendLinkToChangePasswordEvent::class]);

        $knownDate = Carbon::create(2021, 4, 18, 12);
        Carbon::setTestNow($knownDate);

        $user = User::factory()->create([
            'email_verified_at' => Carbon::now()
        ]);
        Profile::factory()->forUser($user)->create();
        $user->assignRole('admin');

        $this->assertDatabaseHas('users', [
            'name' => $user->name,
            'email_verified_at' => Carbon::now(),
        ]);

        Livewire::actingAs($this->sudo)
            ->test(FormUser::class)
            ->call('assign', $user->name)
            ->call('resend');

        Event::assertDispatched(ReSendLinkToChangePasswordEvent::class);
    }
}
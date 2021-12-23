<?php

declare(strict_types=1);

namespace Tests\Roles;

use App\Http\Livewire\System\Roles\FormRoles;
use Blockpc\Models\Role;
use Livewire\Livewire;
use Tests\TestBase;

final class CreateRolesTest extends TestBase
{
    protected Role $ayudante;
    
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();

        $this->ayudante = $this->new_role('ayudante', 'Un ayudante');
    }

    /** @test */
    public function sudo_can_to_see_form_to_create_users_central()
    {
        Livewire::actingAs($this->sudo)
            ->test(FormRoles::class)
            ->assertPropertyWired('name')
            ->assertPropertyWired('display_name')
            ->assertPropertyWired('description')
            ->assertMethodWiredToForm('save');
    }

    /** 
     * @test 
     * @dataProvider validationRules
     */
    public function check_errors_create_role_step_one($field, $value, $rule)
    {
        // Step == 1
        Livewire::actingAs($this->sudo)
            ->test(FormRoles::class)
            ->set($field, $value)
            ->call('step_add')
            ->assertHasErrors([$field => $rule]);
    }

    public function validationRules()
    {
        return [
            'role name is required' => ['name', null, 'required'],
            'role name is too long' => ['name', str_repeat('*', 33), 'max'],
            'role name exists' => ['name', 'ayudante', 'unique'],
            'role display name is required' => ['display_name', null, 'required'],
            'role display name is too long' => ['name', str_repeat('*', 65), 'max'],
            'role description is too long' => ['description', str_repeat('*', 256), 'max']
        ];
    }

    /** 
     * @test 
     * @dataProvider validationRulesStepTwo
     */
    public function check_errors_create_role_step_two($field, $value, $rule)
    {
        Livewire::actingAs($this->sudo)
            ->test(FormRoles::class)
            ->set('step', 2)
            ->set($field, $value)
            ->call('step_add')
            ->assertHasErrors([$field => $rule]);
    }

    public function validationRulesStepTwo()
    {
        return [
            'permissions is required' => ['user_permissions', [], 'required'],
        ];
    }
}
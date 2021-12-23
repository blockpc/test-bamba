<?php

declare(strict_types=1);

namespace Tests\Roles;

use Tests\TestBase;

final class RouteTest extends TestBase
{
    private $route = "roles.index";

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    /** @test */
    public function sudo_can_access_to_roles_page()
    {
        $this->actingAs($this->sudo);
        $response = $this->get(route($this->route));
        $response->assertStatus(200)
            ->assertViewIs('system.roles.index')
            ->assertSeeLivewire('system.roles.table')
            ->assertSeeLivewire('system.roles.form-roles');
    }

    /** @test */
    public function admin_can_access_to_roles_page()
    {
        $this->actingAs($this->admin);
        $response = $this->get(route($this->route));

        $response->assertStatus(200)
            ->assertViewIs('system.roles.index')
            ->assertSeeLivewire('system.roles.table')
            ->assertSeeLivewire('system.roles.form-roles');
    }

    /** @test */
    public function user_without_roles_list_can_access_to_roles_page()
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        
        try {
            $this->actingAs($this->user);
            $response = $this->get(route($this->route));
        } catch (\Throwable $th) {
            $this->assertEquals('User does not have any of the necessary access rights.', $th->getMessage());
        }
    }
}
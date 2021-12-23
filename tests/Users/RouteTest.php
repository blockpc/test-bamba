<?php

declare(strict_types=1);

namespace Tests\Users;

use Tests\TestBase;

final class RouteTest extends TestBase
{
    private $route = "users";

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    /** @test */
    public function sudo_can_access_to_users_page()
    {
        $this->actingAs($this->sudo);
        $response = $this->get(route($this->route));
        $response->assertStatus(200)
            ->assertViewIs('system.users.index')
            ->assertSeeLivewire('system.users.table')
            ->assertSeeLivewire('system.users.form-user');
    }

    /** @test */
    public function admin_can_access_to_users_page()
    {
        $this->actingAs($this->admin);
        $response = $this->get(route($this->route));

        $response->assertStatus(200)
            ->assertViewIs('system.users.index')
            ->assertSeeLivewire('system.users.table')
            ->assertSeeLivewire('system.users.form-user');
    }

    /** @test */
    public function user_without_users_list_can_access_to_users_page()
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
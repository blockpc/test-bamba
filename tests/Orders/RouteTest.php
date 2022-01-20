<?php

declare(strict_types=1);

namespace Tests\Orders;

use Tests\TestBase;

final class RouteTest extends TestBase
{
    private $route = "system.orders.index";

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    /** @test */
    public function user_with_role_sudo_can_access_to_orders_page()
    {
        $this->actingAs($this->sudo);
        $response = $this->get(route($this->route));
        $response->assertStatus(200)
            ->assertViewIs('system.orders.index')
            ->assertSeeLivewire('system.orders.table')
            ->assertSeeLivewire('system.orders.form-order');
    }

    /** @test */
    public function user_with_role_admin_can_access_to_orders_page()
    {
        $this->actingAs($this->admin);
        $response = $this->get(route($this->route));
        $response->assertStatus(200)
            ->assertViewIs('system.orders.index')
            ->assertSeeLivewire('system.orders.table')
            ->assertSeeLivewire('system.orders.form-order');
    }

    /** @test */
    public function user_with_role_user_can_access_to_orders_page_but_no_see_form_order()
    {
        $this->actingAs($this->user);
        $response = $this->get(route($this->route));
        $response->assertStatus(200)
            ->assertViewIs('system.orders.index')
            ->assertSeeLivewire('system.orders.table')
            ->assertDontSeeLivewire('system.orders.form-order');
    }

    /** @test */
    public function any_user_without_roles_list_can_access_to_roles_page()
    {
        $role_ayudante = $this->new_role('ayudante', 'Ayudante');

        $ayudante = $this->new_user([
            'name' => 'ayudante'
        ], $role_ayudante);

        /** @var \Illuminate\Contracts\Auth\Authenticatable $ayudante */

        try {
            $this->actingAs($ayudante);
            $response = $this->get(route($this->route));
        } catch (\Throwable $th) {
            $this->assertEquals('User does not have any of the necessary access rights.', $th->getMessage());
        }
    }
}
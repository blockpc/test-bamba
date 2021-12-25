<?php

declare(strict_types=1);

namespace Tests\Roles;

use App\Http\Livewire\System\Roles\Table;
use Blockpc\Models\Role;
use Livewire\Livewire;
use Tests\TestBase;

final class DeleteAndRestoreRoleTest extends TestBase
{
    protected Role $ayudante;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();

        $this->ayudante = $this->new_role('ayudante', 'Un ayudante');
    }

    /** @test */
    public function can_delete_a_role()
    {
        $this->assertDatabaseHas('roles', [
            'id' => 4,
            'name' => 'ayudante'
        ]);

        Livewire::actingAs($this->sudo)
            ->test(Table::class)
            ->call('delete', 4)
            ->assertHasNoErrors();

        $this->assertDatabaseMissing('roles', [
            'id' => 4,
            'name' => 'ayudante'
        ]);
    }

    /** @test */
    public function can_not_delete_a_role_base()
    {
        Livewire::actingAs($this->sudo)
            ->test(Table::class)
            ->call('delete', 3)
            ->assertHasErrors('delete_role');
    }

    /** @test */
    public function can_not_delete_role_with_users_associated()
    {
        $user_uno = $this->new_user([
            'name' => 'ayudante uno'
        ], $this->ayudante);

        $user_dos = $this->new_user([
            'name' => 'ayudante dos'
        ], $this->ayudante);

        $this->assertDatabaseHas('users', [
            'id' => 4,
            'name' => 'ayudante uno'
        ]);

        Livewire::actingAs($this->sudo)
            ->test(Table::class)
            ->call('delete', $this->ayudante->id)
            ->assertHasErrors('delete_role');
    }

    /** @test */
    public function can_not_restore_a_role_deleted()
    {
        Livewire::actingAs($this->sudo)
            ->test(Table::class)
            ->call('restore', 4)
            ->assertHasErrors('delete_role');
    }
}
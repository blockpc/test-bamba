<?php

declare(strict_types=1);

namespace Tests\Products;

use App\Http\Livewire\System\Products\Table;
use App\Models\Product;
use Carbon\Carbon;
use Livewire\Livewire;
use Tests\TestBase;

final class DeleteAndRestoreProductsTest extends TestBase
{
    private Product $product;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();

        $this->product = Product::create([
            'sku' => 'SKU01',
            'price' => 125.50
        ]);
    }

    /** @test */
    public function role_sudo_can_delete_a_product()
    {
        $knownDate = Carbon::create(2001, 5, 21, 12); // create testing date
        Carbon::setTestNow($knownDate); // set the mock (of course this could be a real mock object)
        
        $this->assertDatabaseHas('products', [
            'id' => 1,
            'sku' => 'SKU01',
            'price' => '125.50',
            'deleted_at' => null
        ]);

        Livewire::actingAs($this->sudo)
            ->test(Table::class)
            ->call('delete', $this->product)
            ->assertHasNoErrors();

        $this->assertDatabaseMissing('products', [
            'id' => 1,
            'deleted_at' => null
        ]);
    }

    /** @test */
    public function role_admin_can_delete_a_product()
    {
        $knownDate = Carbon::create(2001, 5, 21, 12); // create testing date
        Carbon::setTestNow($knownDate); // set the mock (of course this could be a real mock object)
        
        $this->assertDatabaseHas('products', [
            'id' => 1,
            'sku' => 'SKU01',
            'price' => '125.50',
            'deleted_at' => null
        ]);

        Livewire::actingAs($this->admin)
            ->test(Table::class)
            ->call('delete', $this->product)
            ->assertHasNoErrors();

        $this->assertDatabaseMissing('products', [
            'id' => 1,
            'deleted_at' => null
        ]);
    }

    /** @test */
    public function role_without_permissions_can_not_delete_a_product()
    {
        try {
            Livewire::actingAs($this->user)
                ->test(Table::class)
                ->call('delete', $this->product);
        } catch (\Throwable $th) {
            $this->assertEquals('User does not have any of the necessary access rights.', $th->getMessage());
        }
    }

    /** @test */
    public function role_sudo_can_restore_a_product()
    {
        $id = $this->product->id;
        $this->product->delete();

        Livewire::actingAs($this->sudo)
            ->test(Table::class)
            ->call('restore', $id)
            ->assertHasNoErrors();

        $this->assertDatabaseHas('products', [
            'id' => 1,
            'deleted_at' => null,
        ]);
    }

    /** @test */
    public function role_admin_can_restore_a_product()
    {
        $id = $this->product->id;
        $this->product->delete();

        Livewire::actingAs($this->admin)
            ->test(Table::class)
            ->call('restore', $id)
            ->assertHasNoErrors();

        $this->assertDatabaseHas('products', [
            'id' => 1,
            'deleted_at' => null,
        ]);
    }

    /** @test */
    public function role_without_permissions_can_not_restore_a_product()
    {
        try {
            Livewire::actingAs($this->user)
                ->test(Table::class)
                ->call('restore', $this->product);
        } catch (\Throwable $th) {
            $this->assertEquals('User does not have any of the necessary access rights.', $th->getMessage());
        }
    }
}
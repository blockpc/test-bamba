<?php

declare(strict_types=1);

namespace Tests\Products;

use App\Http\Livewire\System\Products\FormProduct;
use App\Models\Product;
use Blockpc\Validators\IsDecimal;
use Livewire\Livewire;
use Tests\TestBase;

final class CreateAndUpdateProductsTest extends TestBase
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
    public function user_sudo_can_see_form_to_create_a_product()
    {
        Livewire::actingAs($this->sudo)
            ->test(FormProduct::class)
            ->assertPropertyWired('product.sku')
            ->assertPropertyWired('product.price')
            ->assertMethodWiredToForm('save');
    }

    /** 
     * @test 
     * @dataProvider validationRules
     */
    public function check_errors_create_products($field, $value, $rule)
    {
        Livewire::actingAs($this->sudo)
            ->test(FormProduct::class)
            ->set($field, $value)
            ->call('save')
            ->assertHasErrors([$field => $rule]);
    }

    public function validationRules()
    {
        return [
            'product sku is required' => ['product.sku', null, 'required'],
            'product sku is too long' => ['product.sku', str_repeat('*', 33), 'max'],
            'product sku exists' => ['product.sku', 'SKU01', 'unique'],
            'product price is required' => ['product.price', null, 'required'],
            'product min price must be 0' => ['product.price', -1.0, new IsDecimal],
        ];
    }

    /** @test */
    public function role_sudo_can_create_a_new_product()
    {
        Livewire::actingAs($this->sudo)
            ->test(FormProduct::class)
            ->set('product.sku', 'SKU02')
            ->set('product.price', '100.25')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('products', [
            'id' => 2,
            'sku' => 'SKU02',
            'price' => '100.25',
        ]);
    }

    /** @test */
    public function role_admin_can_create_a_new_product()
    {
        Livewire::actingAs($this->admin)
            ->test(FormProduct::class)
            ->set('product.sku', 'SKU02')
            ->set('product.price', '100.25')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('products', [
            'id' => 2,
            'sku' => 'SKU02',
            'price' => '100.25',
        ]);
    }

    /** @test */
    public function role_user_can_not_create_a_new_product()
    {
        try {
            Livewire::actingAs($this->user)
                ->test(FormProduct::class);
        } catch (\Throwable $th) {
            $this->assertEquals('User does not have any of the necessary access rights.', $th->getMessage());
        }
    }

    /** @test */
    public function role_sudo_can_update_a_product()
    {
        $this->assertDatabaseHas('products', [
            'id' => 1,
            'sku' => 'SKU01',
            'price' => '125.50',
        ]);

        Livewire::actingAs($this->sudo)
            ->test(FormProduct::class)
            ->call('assign', 1)
            ->assertSet('product.sku', 'SKU01')
            ->assertSet('product.price', '125.50')
            ->set('product.sku', 'SKU00')
            ->set('product.price', '130.00')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseMissing('products', [
            'id' => 1,
            'sku' => 'SKU01',
            'price' => '125.50',
        ]);

        $this->assertDatabaseHas('products', [
            'id' => 1,
            'sku' => 'SKU00',
            'price' => '130.00',
        ]);
    }

    /** @test */
    public function role_admin_can_update_a_product()
    {
        $this->assertDatabaseHas('products', [
            'id' => 1,
            'sku' => 'SKU01',
            'price' => '125.50',
        ]);

        Livewire::actingAs($this->admin)
            ->test(FormProduct::class)
            ->call('assign', 1)
            ->assertSet('product.sku', 'SKU01')
            ->assertSet('product.price', '125.50')
            ->set('product.sku', 'SKU00')
            ->set('product.price', '130.00')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseMissing('products', [
            'id' => 1,
            'sku' => 'SKU01',
            'price' => '125.50',
        ]);

        $this->assertDatabaseHas('products', [
            'id' => 1,
            'sku' => 'SKU00',
            'price' => '130.00',
        ]);
    }
}
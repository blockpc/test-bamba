<?php

declare(strict_types=1);

namespace Tests\Orders;

use App\Http\Livewire\System\Orders\FormOrder;
use App\Models\Product;
use Blockpc\Validators\IsDecimal;
use Livewire\Livewire;
use Tests\TestBase;

final class CreateOrderTest extends TestBase
{
    private Product $product_one;
    private Product $product_two;
    private Product $product_three;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();

        $this->product_one = Product::create([
            'sku' => 'SKU01',
            'price' => 125.50
        ]);

        $this->product_two = Product::create([
            'sku' => 'SKU02',
            'price' => 210.00
        ]);

        $this->product_three = Product::create([
            'sku' => 'SKU03',
            'price' => 50.00
        ]);
    }

    /** @test */
    public function verify_new_products_exists()
    {
        $this->assertDatabaseHas('products', [
            'id' => 1,
            'sku' => 'SKU01',
            'price' => 125.50
        ]);

        $this->assertDatabaseHas('products', [
            'id' => 2,
            'sku' => 'SKU02',
            'price' => 210.00
        ]);

        $this->assertDatabaseHas('products', [
            'id' => 3,
            'sku' => 'SKU03',
            'price' => 50.00
        ]);
    }

    /** @test */
    public function user_sudo_can_create_new_order()
    {
        $products = [
            1 => ['product_id' => 1, 'sku' => 'SKU01', 'quantity' => 1, 'total' => 125.50 ],
            2 => ['product_id' => 2, 'sku' => 'SKU02', 'quantity' => 1, 'total' => 210.00 ],
            3 => ['product_id' => 3, 'sku' => 'SKU03', 'quantity' => 1, 'total' => 50.00 ],
        ];

        $total = collect($products)->sum('total');

        Livewire::actingAs($this->sudo)
            ->test(FormOrder::class)
            ->call('add_product', 1)
            ->call('add_product', 2)
            ->call('add_product', 3)
            ->assertSet('products', $products)
            ->assertSet('total', $total)
            ->call('create')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('orders', [
            'id' => 1,
            'total' => 385.50
        ]);

        $this->assertDatabaseHas('order_product', [
            'id' => 1,
            'order_id' => 1,
            'product_id' => 1,
            'quantity' => 1,
            'total' => 125.50,
        ]);

        $this->assertDatabaseHas('order_product', [
            'id' => 2,
            'order_id' => 1,
            'product_id' => 2,
            'quantity' => 1,
            'total' => 210.00,
        ]);

        $this->assertDatabaseHas('order_product', [
            'id' => 3,
            'order_id' => 1,
            'product_id' => 3,
            'quantity' => 1,
            'total' => 50.00,
        ]);
    }
}
<?php

namespace App\Http\Livewire\System\Products;

use App\Models\Product;
use Blockpc\Traits\AlertBrowserEvent;
use Blockpc\Traits\AuthorizesRoleOrPermission;
use Blockpc\Traits\WithSorting;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination, WithSorting, AlertBrowserEvent, AuthorizesRoleOrPermission;

    protected $listeners = [
        'update-table' => '$refresh',
    ];

    public $search = "";
    public $paginate = 10;
    public $products_deleted;

    public function mount()
    {
        $this->products_deleted = false;
    }

    public function getProductsProperty()
    {
        $products = Product::query();

        $products->when( $this->products_deleted, 
            function($query) {
                $query->onlyTrashed();
            }
        );

        return $products->whereLike(['sku'], $this->search)
            ->latest()
            ->paginate($this->paginate);
    }

    public function render()
    {
        return view('livewire.system.products.table', [
            'products' => $this->products,
        ]);
    }

    public function eliminated()
    {
        $this->products_deleted = !$this->products_deleted;
    }

    public function clear()
    {
        $this->search = "";
    }

    public function delete(Product $product)
    {
        $this->authorizeRoleOrPermission('product delete');
        $sku = $product->sku;
        $product->delete();
        $this->alert("The product {$sku} was deleted", 'Delete Product', 'warning');
    }

    public function restore(int $id)
    {
        $this->authorizeRoleOrPermission('product restore');
        $product = Product::withTrashed()->where('id', $id)->first();
        $product->restore();
        $this->alert("The product {$product->sku} was restore", 'Restore Product');
    }
}

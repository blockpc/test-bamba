<?php

namespace App\Http\Livewire\System\Products;

use App\Models\Product;
use Blockpc\Traits\AlertBrowserEvent;
use Blockpc\Traits\AuthorizesRoleOrPermission;
use Blockpc\Validators\IsDecimal;
use Illuminate\Validation\Rule;
use Livewire\Component;

class FormProduct extends Component
{
    use AlertBrowserEvent, AuthorizesRoleOrPermission;
    
    public Product $product;

    protected $listeners = [
        'cancel-form-product' => 'cancel',
        'assign',
    ];

    public function mount()
    {
        $this->authorizeRoleOrPermission(['product create', 'product update']);
        $this->product = new Product;
    }

    public function render()
    {
        return view('livewire.system.products.form-product');
    }

    public function save()
    {
        $this->authorizeRoleOrPermission(['product create', 'product update']);
        $this->validate();

        $this->product->save();

        $this->product = new Product;

        $this->alert('Un product fue creado', 'Nuevo producto');
        $this->emitTo('system.products.table', 'update-table');
        $this->dispatchBrowserEvent('close-form-product');
    }

    public function rules()
    {
        $rule_sku_unique = $this->product->exists 
            ? Rule::unique('products', 'sku')->ignore($this->product)
            : Rule::unique('products', 'sku');
        return [
            'product.sku' => ['required', 'string', 'max:32', $rule_sku_unique],
            'product.price' => ['required', 'regex:/^\d+(\.\d{1,2})?/', new IsDecimal]
        ];
    }

    protected $messages = [
        'product.price.regex' => 'the price is not numeric value',
    ];

    public function assign(Product $product)
    {
        $this->product = $product;
    }

    public function cancel()
    {
        $this->product = new Product;
        $this->dispatchBrowserEvent('close-form-product');
    }
}

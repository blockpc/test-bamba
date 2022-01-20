<?php

namespace App\Http\Livewire\System\Orders;

use App\Models\Order;
use App\Models\Product;
use Blockpc\Traits\AlertBrowserEvent;
use Blockpc\Validators\IsInteger;
use Illuminate\Validation\Rule;
use Livewire\Component;

class FormOrder extends Component
{
    use AlertBrowserEvent;

    public $search;
    public $products;
    public $total;

    public function mount()
    {
        $this->search = "";
        $this->products = [];
        $this->total = 0;
    }

    public function getOptionsProperty()
    {
        return Product::whereLike(['sku'], $this->search)->get();
    }

    public function render()
    {
        return view('livewire.system.orders.form-order', [
            'options' => $this->options,
        ]);
    }

    public function add_product(Product $product)
    {
        $id = $product->id;
        if ( isset($this->products[$id]) ) {
            $quantity = ++$this->products[$id]['quantity'];
            $this->products[$id]['total'] = (float) number_format($product->price * $quantity, 2);
        } else {
            $this->products[$id]['product_id'] = $id;
            $this->products[$id]['sku'] = $product->sku;
            $this->products[$id]['quantity'] = 1;
            $this->products[$id]['total'] = (float) number_format($product->price, 2);
        }

        $this->total = collect($this->products)->sum('total');
        $this->search = "";
    }

    public function select()
    {
        if ( !$product = Product::whereLike(['sku'], $this->search)->first() ) {
            $this->addError('options', "{$this->search} no es un producto valido");
            $this->search = "";
            return;
        }
        $this->add_product($product);
    }

    public function create()
    {
        $this->validate();

        $order = Order::create([
            'total' => $this->total,
        ]);

        $products = $this->parse();

        $order->products()->attach($products);

        $this->alert('Se ha creado una nueva orden de trabajo', 'Nueva Orden de Trabajo');
        $this->emitTo('system.orders.table', 'update-table');
        $this->dispatchBrowserEvent('close-form-order');
    }

    public function rules()
    {
        return [
            'products' => ['required', 'array'],
            'products.*.product_id' => ['required', Rule::exists('products', 'id')],
            'total' => ['required', 'numeric']
        ];
    }

    public function clear()
    {
        $this->search = "";
    }

    private function parse() : array
    {
        $products = [];
        foreach ($this->products as $product) {
            $products[] = [
                'product_id' => $product['product_id'],
                'quantity' => $product['quantity'],
                'total' => $product['total'],
            ];
        }
        return $products;
    }
}

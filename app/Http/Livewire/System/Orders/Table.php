<?php

namespace App\Http\Livewire\System\Orders;

use App\Models\Order;
use Blockpc\Traits\WithSorting;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination, WithSorting;

    public $paginate = 10;

    protected $listeners = [
        'update-table' => '$refresh',
    ];

    public function getOrdersProperty()
    {
        return Order::latest()->paginate($this->paginate);
    }

    public function render()
    {
        return view('livewire.system.orders.table', [
            'orders' => $this->orders,
        ]);
    }
}

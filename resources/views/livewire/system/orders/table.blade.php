<div>
    <div class="flex flex-col space-y-4">
        <div class="w-full">
            <x-tables.table class="text-xs md:text-sm">
                <x-slot name="thead">
                    <tr>
                        <x-tables.th class="w-64">{{__('ID')}}</x-tables.th>
                        <x-tables.th>{{__('Total')}}</x-tables.th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @forelse ($orders as $order)
                    <x-tables.row wire:loading.class.delay="opacity-50">
                        <x-tables.td>
                            <span class="text-lg">{{ $order->id }}</span>
                        </x-tables.td>
                        <x-tables.td>
                            <span class="text-lg">{{ price_format($order->total) }}</span>
                        </x-tables.td>
                    </x-tables.row>
                    @empty
                    <x-tables.row wire:loading.class.delay="opacity-50">
                        <x-tables.td class="font-semibold text-center" colspan="3">
                            <span>Sin registros encontrados</span>
                        </x-tables.td>
                    </x-table>
                    @endforelse
                </x-slot>
            </x-tables.table>
        </div>
        <div class="w-full">
            {{ $orders->links('layouts.backend.pagination') }}
        </div>
    </div>
</div>

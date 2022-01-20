<div>
    <div class="w-full">
        <div class="grid grid-cols-3 gap-4">
            <div class="col-span-3 md:col-span-2">
                <div class="w-64" x-data="{open:false}" x-on:click.away="open=false">
                    <button type="button" class="border border-gray-300 p-2 rounded text-dark shadow-inner w-64 flex justify-between items-center text-sm focus:outline-none" x-on:click="open=!open">
                        <span class="float-left">{{'Select Product'}}</span>
                        <svg class="h-4 transform float-right fill-current text-dark" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 129 129" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 129 129" :class="{'rotate-180': open}">
                            <g><path d="m121.3,34.6c-1.6-1.6-4.2-1.6-5.8,0l-51,51.1-51.1-51.1c-1.6-1.6-4.2-1.6-5.8,0-1.6,1.6-1.6,4.2 0,5.8l53.9,53.9c0.8,0.8 1.8,1.2 2.9,1.2 1,0 2.1-0.4 2.9-1.2l53.9-53.9c1.7-1.6 1.7-4.2 0.1-5.8z"/></g>
                        </svg>
                    </button>
                    <div class="absolute z-10 w-64 rounded shadow-md bg-white" x-show="open" x-cloak>
                        <ul class="list-reset p-2 max-h-64 overflow-y-auto text-sm bg-dark">
                            <li>
                                <input wire:model="search" wire:keydown.enter="select" @keydown.enter="open = false; $event.target.blur()" type="text" class="border-2 rounded h-10 w-full p-2 bg-transparent">
                            </li>
                            @forelse ($options as $item)
                            <li class="" wire:click="add_product({{$item->id}})" x-on:click="open=false" id="product-{{$item->id}}">
                                <p class="p-2 w-full text-dark hover:bg-gray-300 dark:hover:bg-gray-600 flex justify-between items-center cursor-pointer">
                                    <span>{{$item->sku}}</span>
                                    <span>{{price_format($item->price)}}</span>
                                </p>
                            </li>
                            @empty
                            <li x-on:click="open=false" id="no-brand">
                                <p class="p-2 block text-red-300 dark:hover:text-red-800 hover:bg-red-200 cursor-pointer" wire:click="clear">{{__('No products founds')}}</p>
                            </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
                @error('options')
                <div class="text-error">{{$message}}</div>
                @enderror
            </div>
            <div class="col-span-3 md:col-span-1">
                @if ( session()->has('options') && $error = session('options'))
                    <div class="alert-danger">
                        <p>{{$error}}</p>
                    </div>
                @endif
            </div>
            <div class="col-span-3 md:col-span-2">
                <x-tables.table class="text-xs md:text-sm">
                    <x-slot name="thead">
                        <tr>
                            <x-tables.th>{{__('SKU')}}</x-tables.th>
                            <x-tables.th>{{__('Cantidad')}}</x-tables.th>
                            <x-tables.th>{{__('SubTotal')}}</x-tables.th>
                        </tr>
                    </x-slot>
                    <x-slot name="tbody">
                        @forelse ($products as $product)
                        <x-tables.row wire:loading.class.delay="opacity-50">
                            <x-tables.td>
                                <span class="">{{ $product['sku'] }}</span>
                            </x-tables.td>
                            <x-tables.td>
                                <span class="">{{ $product['quantity'] }}</span>
                            </x-tables.td>
                            <x-tables.td>
                                <span class="">{{ price_format($product['total']) }}</span>
                            </x-tables.td>
                        </x-tables.row>
                        @empty
                        <x-tables.row wire:loading.class.delay="opacity-50">
                            <x-tables.td class="font-semibold text-center" colspan="3">
                                <span>Sin productos agregados</span>
                            </x-tables.td>
                        </x-table>
                        @endforelse
                    </x-slot>
                </x-tables.table>
                <div class="flex justify-end items-center space-x-2 w-full">
                    @if ( count($products) )
                    <button type="button" wire:click="create" class="btn btn-primary text-sm">{{__('Create Order')}}</button>
                    <button type="button" wire:click="clean" class="btn btn-warning text-sm">{{__('Cancel')}}</button>
                    @endif
                </div>
            </div>
            <div class="col-span-3 md:col-span-1">
                <div class="bg-gray-300 dark:bg-gray-700 text-dark rounded-md shadow-md p-4">
                    <div class="flex justify-between items-center">
                        <div>Numero de productos</div>
                        <div>{{ count($products) }}</div>
                    </div>
                    <div class="flex justify-between items-center">
                        <div>Total</div>
                        <div>{{ price_format($total) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

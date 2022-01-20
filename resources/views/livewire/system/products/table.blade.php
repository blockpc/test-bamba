<div>
    <div class="flex flex-col space-y-4">
        <div class="flex flex-row">
            <div class="w-full mr-1 relative rounded-md shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <span class="dark:text-gray-200 text-gray-700 sm:text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-4 h-4 fill-current"><path d="M10 18a7.952 7.952 0 0 0 4.897-1.688l4.396 4.396 1.414-1.414-4.396-4.396A7.952 7.952 0 0 0 18 10c0-4.411-3.589-8-8-8s-8 3.589-8 8 3.589 8 8 8zm0-14c3.309 0 6 2.691 6 6s-2.691 6-6 6-6-2.691-6-6 2.691-6 6-6z"></path><path d="M11.412 8.586c.379.38.588.882.588 1.414h2a3.977 3.977 0 0 0-1.174-2.828c-1.514-1.512-4.139-1.512-5.652 0l1.412 1.416c.76-.758 2.07-.756 2.826-.002z"></path></svg>
                    </span>
                </div>
                <input wire:model="search" type="text" id="search" class="input-search" placeholder="Search">
                @if ( $search )
                <button type="button" wire:click="clean" class="absolute inset-y-0 right-16 flex items-center focus:ring-red-300 border-red-300 focus:border-red-300 text-red-500 hover:text-red-600">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-4 h-4 fill-current"><path d="m16.192 6.344-4.243 4.242-4.242-4.242-1.414 1.414L10.535 12l-4.242 4.242 1.414 1.414 4.242-4.242 4.243 4.242 1.414-1.414L13.364 12l4.242-4.242z"></path></svg>
                </button>
                @endif
                @if ( $paginate && count($products) >= 10 )
                <div class="absolute inset-y-0 right-0 flex items-center">
                    <select wire:model="paginate" id="paginate" name="paginate" class="focus:ring-gray-500 border-gray-500 focus:border-gray-400 h-full py-0 pl-2 pr-7 border-transparent bg-transparent dark:text-gray-200 text-gray-700 dark:bg-gray-600 sm:text-sm rounded-md">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="30">50</option>
                    </select>
                </div>
                @endif
            </div>
            @if ( isset($products_deleted) && current_user()->can('product delete') )
                @if(!$products_deleted)
                <button wire:click="eliminated" type="button" class="btn-sm btn-danger flex fles-row items-center m-0 space-x-2 h-8">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-4 h-4 fill-current"><path d="M5 20a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8h2V6h-4V4a2 2 0 0 0-2-2H9a2 2 0 0 0-2 2v2H3v2h2zM9 4h6v2H9zM8 8h9v12H7V8z"></path><path d="M9 10h2v8H9zm4 0h2v8h-2z"></path></svg>
                </button>
                @else
                <button wire:click="eliminated" type="button" class="btn-sm btn-success flex fles-row items-center m-0 space-x-2 h-8">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </button>
                @endif
            @endif
        </div>
        <div class="w-full scproductlbar-thin scproductlbar-thumb-gray-500 scproductlbar-track-gray-400 overflow-x-scproductl">
            <x-tables.table class="text-xs md:text-sm">
                <x-slot name="thead">
                    <tr>
                        <x-tables.th class="w-64">{{__('SKU')}}</x-tables.th>
                        <x-tables.th>{{__('Price')}}</x-tables.th>
                        <th></th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @forelse ($products as $product)
                    <x-tables.row wire:loading.class.delay="opacity-50">
                        <x-tables.td>
                            <span class="text-lg">{{ $product->sku }}</span>
                        </x-tables.td>
                        <x-tables.td>{{ price_format($product->price) }}</x-tables.td>
                        <x-tables.td>
                            <div class="flex justify-end space-x-2">
                                @if ( isset($products_deleted) && $products_deleted )
                                    @if ( current_user()->can('product restore') )
                                    <div class="" x-data="{ showModal : false }">
                                        <button class="btn-sm btn-info" type="button" x-on:click="showModal = true"  title="{{__('Restore product')}}">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-4 h-4 fill-current"><path d="M9 10h6c1.654 0 3 1.346 3 3s-1.346 3-3 3h-3v2h3c2.757 0 5-2.243 5-5s-2.243-5-5-5H9V5L4 9l5 4v-3z"></path></svg>
                                        </button>
                                        <x-modals.mini class="border-2 border-blue-800">
                                            <x-slot name="title">{{__('Restore product')}}</x-slot>
                                            <x-slot name="action">
                                                <button x-on:click="showModal = false" class="btn btn-warning">{{__('Cancel')}}</button>
                                                <button wire:click="restore({{$product->id}})" type="button" class="btn btn-primary" x-on:click="showModal = false">{{__('Restore product')}}</button>
                                            </x-slot>
                                            <h2 class="py-4 text-2xl font-semibold mx-auto">Product {{$product->sku}}</h2>
                                            <p>¿{{__('Are you sure you want to restore the associated product?')}}</p>
                                        </x-modals.mini>
                                    </div>
                                    @endif
                                @else
                                    @if ( current_user()->can('product update') )
                                    <button class="btn-sm btn-success" type="button" x-on:click="open='edit', Livewire.emitTo('system.products.form-product', 'assign', '{{$product->id}}')" title="{{__('Edit product')}}">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-4 h-4 fill-current"><path d="M4 21a1 1 0 0 0 .24 0l4-1a1 1 0 0 0 .47-.26L21 7.41a2 2 0 0 0 0-2.82L19.42 3a2 2 0 0 0-2.83 0L4.3 15.29a1.06 1.06 0 0 0-.27.47l-1 4A1 1 0 0 0 3.76 21 1 1 0 0 0 4 21zM18 4.41 19.59 6 18 7.59 16.42 6zM5.91 16.51 15 7.41 16.59 9l-9.1 9.1-2.11.52z"></path></svg>
                                    </button>
                                    @endif
                                    @if ( current_user()->can('product delete') )
                                    <div class="" x-data="{ showModal : false }">
                                        <button class="btn-sm btn-danger" type="button" x-on:click="showModal = true" placeholder="{{__('Delete product')}}">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-4 h-4 fill-current"><path d="M5 20a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8h2V6h-4V4a2 2 0 0 0-2-2H9a2 2 0 0 0-2 2v2H3v2h2zM9 4h6v2H9zM8 8h9v12H7V8z"></path><path d="M9 10h2v8H9zm4 0h2v8h-2z"></path></svg>
                                        </button>
                                        <x-modals.mini class="border-2 border-red-800">
                                            <x-slot name="title">{{__('Delete product')}}</x-slot>
                                            <x-slot name="action">
                                                <button x-on:click="showModal = false" class="btn btn-warning">{{__('Cancel')}}</button>
                                                <button wire:click="delete('{{$product->id}}')" type="button" class="btn btn-danger" x-on:click="showModal = false">{{__('Delete product')}}</button>
                                            </x-slot>
                                            <h2 class="py-4 text-2xl font-semibold mx-auto">Product {{$product->sku}}</h2>
                                            <p>{{__('Are you sure you want to delete the associated product?')}}</p>
                                        </x-modals.mini>
                                    </div>
                                    @endif
                                @endif
                            </div>
                        </x-tables.td>
                    </x-tables.row>
                    @empty
                    <x-tables.row wire:loading.class.delay="opacity-50">
                        <x-tables.td class="font-semibold text-center" colspan="3">
                            <span>Sin registros encontrados 
                                @if ($search)
                                    para <b>{{ $search }}</b>
                                @endif
                            </span>
                        </x-tables.td>
                    </x-table>
                    @endforelse
                </x-slot>
            </x-tables.table>
        </div>
        <div class="w-full">
            {{ $products->links('layouts.backend.pagination') }}
        </div>
    </div>
</div>

@extends('layouts.backend.app')

@section('title', __('Orders List'))

@section('content')
<div class="bg-dark overflow-hidden shadow-sm sm:rounded-lg px-1" x-data="{open: 'table'}" @close-form-order.window="open = 'table'">
    <div class="py-4 bg-dark border-b border-gray-200 dark:border-gray-600 flex justify-between items-center">
        <div class="flex items-center space-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6 fill-current"><path d="M21 4H2v2h2.3l3.28 9a3 3 0 0 0 2.82 2H19v-2h-8.6a1 1 0 0 1-.94-.66L9 13h9.28a2 2 0 0 0 1.92-1.45L22 5.27A1 1 0 0 0 21.27 4 .84.84 0 0 0 21 4zm-2.75 7h-10L6.43 6h13.24z"></path><circle cx="10.5" cy="19.5" r="1.5"></circle><circle cx="16.5" cy="19.5" r="1.5"></circle></svg>
            <span x-show="open=='table'">{{__('Orders List')}}</span>
            <span x-show="open=='new'">{{__('New Order')}}</span>
            <span x-show="open=='edit'">{{__('Edit Order')}}</span>
        </div>
        <div class="">
            @if ( current_user()->can('order create') )
            <button class="btn-sm btn-primary flex items-center space-x-2" x-show="open=='table'" x-on:click="open='new'" title="{{__('New order')}}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M19 11h-6V5h-2v6H5v2h6v6h2v-6h6z"></path></svg>
            </button>
            <button class="btn-sm btn-warning flex items-center space-x-2" x-show="open!='table'" x-on:click="open='table', Livewire.emitTo('system.orders.form-order', 'cancel-form-order')" title="{{__('Cancel')}}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </button>
            @endif
        </div>
    </div>
    <div class="py-4">
        <div class="" x-show="open=='table'">
            @livewire('system.orders.table', [], key('system-orders-table-'.current_user()->id))
        </div>
        <div class="" x-show="open!='table'">
            @if ( current_user()->can('order create') )
            @livewire('system.orders.form-order', [], key('system-orders-form-order-'.current_user()->id))
            @endif
        </div>
    </div>
</div>
@endsection
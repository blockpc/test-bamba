@extends('layouts.backend.app')

@section('title', __('Users List'))

@section('content')
<div class="bg-dark overflow-hidden shadow-sm sm:rounded-lg px-1" x-data="{open: 'table'}">
    <div class="py-4 bg-dark border-b border-gray-200 dark:border-gray-600 flex justify-between items-center">
        <div class="text-lg font-semibold">
            <span x-show="open=='table'">{{__('Users List')}}</span>
            <span x-show="open=='new'">{{__('New User')}}</span>
            <span x-show="open=='edit'">{{__('Edit User')}}</span>
        </div>
        <div class="">
            @if ( current_user()->can('user create') )
            <button class="btn-sm btn-primary flex items-center space-x-2" x-show="open=='table'" x-on:click="open='new'">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M19 11h-6V5h-2v6H5v2h6v6h2v-6h6z"></path></svg>
            </button>
            <button class="btn-sm btn-warning flex items-center space-x-2" x-show="open!='table'" x-on:click="open='table', Livewire.emitTo('system.users.form-user', 'cancel-form-user')">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M5 11h14v2H5z"></path></svg>
                <span>{{__('Cancel')}}</span>
            </button>
            @endif
        </div>
    </div>
    <div class="py-4">
        <div class="" x-show="open=='table'">
            @livewire('system.users.table', [], key('system.users.table-'.current_user()->id))
        </div>
        <div class="" x-show="open!='table'">
            @livewire('system.users.form-user', [], key('system.users.form-user-'.current_user()->id))
        </div>
    </div>
</div>
@endsection
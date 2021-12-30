@extends('layouts.backend.app')

@section('title', __('Users List'))

@section('content')
<div class="bg-dark overflow-hidden shadow-sm sm:rounded-lg px-1" x-data="{open: 'table'}">
    <div class="py-4 bg-dark border-b border-gray-200 dark:border-gray-600 flex justify-between items-center">
        <div class="flex items-center space-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5 fill-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
            <span x-show="open=='table'">{{__('Users List')}}</span>
            <span x-show="open=='new'">{{__('New User')}}</span>
            <span x-show="open=='edit'">{{__('Edit User')}}</span>
        </div>
        <div class="">
            @if ( current_user()->can('user create') )
            <button class="btn-sm btn-primary flex items-center space-x-2" x-show="open=='table'" x-on:click="open='new'" title="{{__('New User')}}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M19 11h-6V5h-2v6H5v2h6v6h2v-6h6z"></path></svg>
            </button>
            <button class="btn-sm btn-warning flex items-center space-x-2" x-show="open!='table'" x-on:click="open='table', Livewire.emitTo('system.users.form-user', 'cancel-form-user')" title="{{__('Cancel')}}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
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
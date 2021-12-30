@extends('layouts.backend.app')

@section('title', __('Roles List'))

@section('content')
<div class="bg-dark overflow-hidden shadow-sm sm:rounded-lg px-1" x-data="{open: 'table'}">
    <div class="py-4 bg-dark border-b border-gray-200 dark:border-gray-600 flex justify-between items-center">
        <div class="flex items-center space-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5 fill-current"><path d="M12 14l9-5-9-5-9 5 9 5z" /><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" /></svg>
            <span x-show="open=='table'">{{__('Roles List')}}</span>
            <span x-show="open=='new'">{{__('New Role')}}</span>
            <span x-show="open=='edit'">{{__('Edit Role')}}</span>
        </div>
        <div class="">
            @if ( current_user()->can('role create') )
            <button class="btn-sm btn-primary flex items-center space-x-2" x-show="open=='table'" x-on:click="open='new'" title="{{__('New Role')}}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M19 11h-6V5h-2v6H5v2h6v6h2v-6h6z"></path></svg>
            </button>
            <button class="btn-sm btn-warning flex items-center space-x-2" x-show="open!='table'" x-on:click="open='table', Livewire.emitTo('system.roles.form-roles', 'cancel-form-user')" title="{{__('Cancel')}}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </button>
            @endif
        </div>
    </div>
    <div class="py-4">
        <div class="" x-show="open=='table'">
            @livewire('system.roles.table', [], key('system.roles.table-'.current_user()->id))
        </div>
        <div class="" x-show="open!='table'">
            @livewire('system.roles.form-roles', [], key('system.roles.form-user-'.current_user()->id))
        </div>
    </div>
</div>
@endsection
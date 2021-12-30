@extends('layouts.backend.app')

@section('title', __('Permissions List'))

@section('content')
<div class="bg-dark overflow-hidden shadow-sm sm:rounded-lg px-1">
    <div class="py-4 bg-dark border-b border-gray-200 dark:border-gray-600 flex justify-between items-center">
        <div class="flex space-x-2 items-center">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5 fill-current"><path d="M17.868 4.504A1 1 0 0 0 17 4H3a1 1 0 0 0-.868 1.496L5.849 12l-3.717 6.504A1 1 0 0 0 3 20h14a1 1 0 0 0 .868-.504l4-7a.998.998 0 0 0 0-.992l-4-7zM16.42 18H4.724l3.145-5.504a.998.998 0 0 0 0-.992L4.724 6H16.42l3.429 6-3.429 6z"></path></svg>
            <span>{{__('Permissions')}}</span>
        </div>
        <div class=""></div>
    </div>
    <div class="py-4">
        @livewire('system.permissions.table', [], key('system.permissions.table-'.current_user()->id))
    </div>
</div>
@endsection
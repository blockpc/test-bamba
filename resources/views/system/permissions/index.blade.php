@extends('layouts.backend.app')

@section('title', __('Permissions List'))

@section('content')
<div class="bg-dark overflow-hidden shadow-sm sm:rounded-lg px-1">
    <div class="py-4 bg-dark border-b border-gray-200 dark:border-gray-600 flex justify-between items-center">
        <div class="text-lg font-semibold">
            <span>{{__('Permissions List')}}</span>
        </div>
        <div class=""></div>
    </div>
    <div class="py-4">
        @livewire('system.permissions.table', [], key('system.permissions.table-'.current_user()->id))
    </div>
</div>
@endsection
@extends('layouts.backend.app')

@section('title', 'Dashboard')

@section('content')
<div class="bg-dark overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-4 bg-dark border-b border-gray-200 dark:border-gray-600 flex justify-between items-center">
        <div class="">{{__('Dashboard')}}</div>
        <div class=""></div>
    </div>
    <div class="" x-cloak>
        @livewire('system.dashboards.sudo', [], key('system.dashboards.sudo-'.$user->id))
    </div>
</div>
@endsection
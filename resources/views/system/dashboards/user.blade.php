@extends('layouts.backend.app')

@section('title', 'Dashboard')

@section('content')
<div class="bg-dark overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-4 bg-dark border-b border-gray-200 dark:border-gray-600 flex justify-between items-center">
        <div class="flex space-x-2 items-center">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5 fill-current"><path d="M4 11h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1zm1-6h4v4H5V5zm15-2h-6a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1zm-1 6h-4V5h4v4zm-9 12a1 1 0 0 0 1-1v-6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6zm-5-6h4v4H5v-4zm13-1h-2v2h-2v2h2v2h2v-2h2v-2h-2z"></path></svg>
            <span>{{__('Dashboard')}}</span>
        </div>
        <div class=""></div>
    </div>
    <div class="">
        <p class="mt-4">Vista Usuario.</p>
    </div>
</div>
@endsection
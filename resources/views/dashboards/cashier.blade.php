@extends('layouts.backend.app')

@section('title', 'Dashboard')

@section('content')
<div class="bg-dark overflow-hidden shadow-sm sm:rounded-lg pb-2">
    <div class="p-4 bg-dark border-b border-gray-200 dark:border-gray-600 flex justify-between items-center">
        <div class="">
            @if (current_user()->sucursal)
            {{__('Dashboard Sucursal')}}: <span class="text-base font-semibold">{{current_user()->sucursal->name}}</span>
            @else
            {{__('Dashboard')}}: <span class="text-base font-semibold">{{$setting->name}}</span>
            @endif
        </div>
        <div class="">
            <a href="{{route('cashier')}}" class="btn-sm btn-primary flex items-center space-x-2">
                {{__('Cashier')}}
            </a>
        </div>
    </div>
    <div class="">
        
    </div>
</div>
@endsection
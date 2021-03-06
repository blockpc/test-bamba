<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" href="{{ global_asset('img/favicon.ico') }}" type="image/x-icon">

        <title>{{ config('app.name', 'Laravel') }} | {{ tenant('id') ?? 'Central' }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ global_asset('css/app.css') }}">
        <style>
            [x-cloak] { 
                display: none !important;
            }
        </style>

        @livewireStyles

        <!-- Scripts -->
        <script src="{{ global_asset('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased text-dark bg-dark" x-data="{ mode: localStorage.theme == 'dark' }">
        <div class="min-h-screen">
            @include('layouts.guest.navigation')

            <!-- Page Heading -->
            <header class="shadow">
                <div class="content">
                    @include('layouts.frontend.messages')
                    @yield('header')
                </div>
            </header>

            <main class="content">
                @yield('content')
            </main>
        </div>
        @livewireScripts
    </body>
</html>
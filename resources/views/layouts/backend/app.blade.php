<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">

        <title>@yield('title') | {{config('app.name', 'BlockPC')}}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;600;700&display=swap">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <style>
            [x-cloak] { 
                display: none !important;
            }
        </style>

        @livewireStyles
        @toastr_css
        @stack('styles')

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased text-dark bg-dark overflow-y-auto scrollbar-thin scrollbar-thumb-gray-400">
        <div class="relative min-h-screen md:flex flex-col" x-data="{sidebar:false, mode: localStorage.theme == 'dark'}">
            {{-- navbar --}}
            @include('layouts.backend.navbar')
            {{-- sidebar --}}
            @include('layouts.backend.sidebar')
            <div class="flex container max-w-7xl mx-auto">
                <div class="flex flex-col justify-between px-2 sm:px-4 space-y-2 min-h-screen w-full">
                    <main class="pt-16">
                        @include('layouts.backend.messages')
                        @yield('content')
                    </main>
                    <footer class="h-16 p-2 sm:p-4">
                        <div class="flex justify-between items-center">
                            <div class="">
                                <span>{{config('app.name', 'BlockPC') }}</span>
                            </div>
                            <div class="">BlockPC @ 2021</div>
                        </div>
                    </footer>
                </div>
            </div>
        </div>
        @livewireScripts
        <script src="https://cdn.jsdelivr.net/gh/livewire/turbolinks@v0.1.x/dist/livewire-turbolinks.js" data-turbolinks-eval="false" data-turbo-eval="false"></script>
        @jquery
        @toastr_js
        @toastr_render
        @stack('scripts')
    </body>
</html>
<nav x-data="{ open: false }" class="nav-dark">
    {{-- Primary Navigation Menu --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                {{-- Logo --}}
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <x-application-logo class="block h-10 w-auto fill-current text-dark" />
                    </a>
                </div>

                {{-- Navigation Links --}}
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        {{ __('Home') }}
                    </x-nav-link>
                </div>
            </div>

            {{-- Settings Dropdown --}}
            <div class="flex space-x-4">
                <div class="px-2 h-16 flex">
                    <button type="button" x-on:click="mode=false" x-show="mode" class="setMode" id="sun">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </button>
                    <button type="button" x-on:click="mode=true" x-show="!mode" class="setMode" id="dark">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </button>
                </div>

                {{-- Hamburger --}}
                <div class="-mr-2 flex items-center sm:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md focus:bg-gray-200 dark:focus:bg-gray-700 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- User/login options --}}
                <div class="hidden sm:flex sm:items-center">
                    @if ( current_user() )
                    <x-dropdown align="right" width="64">
                        <x-slot name="trigger">
                            <button class="flex items-center space-x-2 text-sm font-medium text-dark hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                <div>
                                    <img class="rounded-full w-8 h-8 text-gray-600" src="{{ image_profile() }}" alt="{{ current_user()->name }}">
                                </div>
                                <div :class="open ? 'transform rotate-180' : 'transform rotate-0'">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>
    
                        <x-slot name="content">
                            <div class="flex items-center space-x-4 border-b-2 border-gray-200 dark:border-gray-600 pb-2">
                                <div class="pl-2">
                                    <img class="rounded-full w-8 h-8 text-gray-600" src="{{ image_profile() }}" alt="{{ current_user()->name }}">
                                </div>
                                <div class="">
                                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ current_user()->name }}</div>
                                    <div class="font-medium text-sm text-gray-500 dark:text-gray-400">{{ current_user()->email }}</div>
                                </div>
                            </div>
                            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                                {{ __('Dashboard') }}
                            </x-responsive-nav-link>
                            <hr class="border border-gray-600 w-50">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-logout-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-logout-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                    @else
                    <div class="space-x-8 flex h-16">
                        <x-nav-link :href="route('login')" :active="request()->routeIs('login')">
                            {{ __('Log In') }}
                        </x-nav-link>
                        <x-nav-link :href="route('register')" :active="request()->routeIs('register')">
                            {{ __('Register') }}
                        </x-nav-link>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Responsive Navigation Menu --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        {{-- Responsive Settings Options --}}
        <div class="pt-4 pb-1 border-t border-b border-gray-500">
            @if ( current_user() )
            <div class="px-4 flex items-center space-x-4 border-b-2 border-gray-600 pb-2">
                <div class="">
                    <img class="rounded-full w-8 h-8 text-gray-600" src="{{ image_profile() }}" alt="{{ current_user()->name }}">
                </div>
                <div class="">
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ current_user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500 dark:text-gray-400">{{ current_user()->email }}</div>
                </div>
            </div>
            <div class="space-y-1">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-logout-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-logout-link>
                </form>
            </div>
            @else
            <x-responsive-nav-link :href="route('login')" :active="request()->routeIs('login')">
                {{ __('Log In') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('register')" :active="request()->routeIs('register')">
                {{ __('Register') }}
            </x-responsive-nav-link>
            @endif
        </div>
    </div>
</nav>

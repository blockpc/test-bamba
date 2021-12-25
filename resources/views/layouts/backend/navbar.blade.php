<div class="w-full bg-white dark:bg-gray-800 text-dark flex justify-between h-16 z-10 fixed">
    {{-- logo --}}
    <div class="w-auto md:w-64 flex items-center space-x-4 shadow px-2 sm:px-4">
        <x-application-logo class="h-8 w-8" />
        <span class="text-lg font-bold">{{ config('app.name', 'BlockPC') }}</span>
    </div>
    <div class="flex-1">
        {{-- mobile menu button --}}
        <button class="h-16 mobile-menu-button p-4" x-on:click="sidebar = !sidebar">
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path :class="{'hidden': sidebar, 'inline-flex': ! sidebar }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                <path :class="{'hidden': ! sidebar, 'inline-flex': sidebar }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    <div class="flex items-center space-x-2 shadow mx-4">
        {{-- dark mode button --}}
        <div class="h-16 flex">
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
        {{-- Responsive User Options --}}
        <x-dropdown class="" align="right" width="64">
            <x-slot name="trigger">
                <button class="flex items-center space-x-2 text-sm font-medium text-dark transition duration-150 ease-in-out">
                    <div class="">
                        <img class="rounded-full w-8 h-8 text-gray-600" src="{{ image_profile() }}" alt="{{ current_user()->profile->fullname }}">
                    </div>
                    <div :class="open ? 'transform rotate-180' : 'transform rotate-0'">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </button>
            </x-slot>
            <x-slot name="content">
                <div class="flex items-center space-x-2 border-b-2 border-gray-200 dark:border-gray-600 pb-4">
                    <div class="w-16">
                        <img class="rounded-full text-gray-600" src="{{ image_profile() }}" alt="{{ current_user()->profile->fullname }}">
                    </div>
                    <div>
                        <div class="font-bold text-base text-gray-800 dark:text-gray-200">{{ current_user()->profile->fullname }}</div>
                        <div class="font-medium text-sm text-gray-500 dark:text-gray-400">{{ current_user()->cargo }}</div>
                    </div>
                </div>
                <x-sidebar-link :href="route('profile')" :active="request()->routeIs('profile')">
                    {{ __('Profile User') }}
                </x-sidebar-link>
                <hr class="border border-gray-200 dark:border-gray-600">
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
    </div>
</div>
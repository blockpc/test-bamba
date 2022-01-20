<div class="bg-white dark:bg-gray-800 w-64 fixed h-sidebar left-0 top-16 transform transition-all duration-500 ease-in-out z-50 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-400 py-2 shadow font-roboto font-semibold" :class="sidebar ? 'translate-x-0' : '-translate-x-full'" x-on:click.away="sidebar=false" x-show="sidebar" x-cloak
x-transition:enter="translate-x-0 ease-out duration-200"
x-transition:enter-start="opacity-0"
x-transition:enter-end="opacity-100"
x-transition:leave="translate-x-0 ease-in duration-200"
x-transition:leave-start="opacity-100"
x-transition:leave-end="opacity-0">
    {{-- menu sidebar --}}
    <x-sidebar-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
        <div class="flex space-x-2 items-center">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5 fill-current"><path d="M4 11h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1zm1-6h4v4H5V5zm15-2h-6a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1zm-1 6h-4V5h4v4zm-9 12a1 1 0 0 0 1-1v-6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6zm-5-6h4v4H5v-4zm13-1h-2v2h-2v2h2v2h2v-2h2v-2h-2z"></path></svg>
            <span>{{__('Dashboard')}}</span>
        </div>
    </x-sidebar-link>
    <hr class="border border-gray-200 dark:border-gray-600 mx-2">
    @if ( current_user()->can('product list') )
    <x-sidebar-link :href="route('system.products.index')" :active="request()->routeIs('system.products.index')">
        <div class="flex space-x-2 items-center">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5 fill-current"><path d="m21.406 6.086-9-4a1.001 1.001 0 0 0-.813 0l-9 4c-.02.009-.034.024-.054.035-.028.014-.058.023-.084.04-.022.015-.039.034-.06.05a.87.87 0 0 0-.19.194c-.02.028-.041.053-.059.081a1.119 1.119 0 0 0-.076.165c-.009.027-.023.052-.031.079A1.013 1.013 0 0 0 2 7v10c0 .396.232.753.594.914l9 4c.13.058.268.086.406.086a.997.997 0 0 0 .402-.096l.004.01 9-4A.999.999 0 0 0 22 17V7a.999.999 0 0 0-.594-.914zM12 4.095 18.538 7 12 9.905l-1.308-.581L5.463 7 12 4.095zM4 16.351V8.539l7 3.111v7.811l-7-3.11zm9 3.11V11.65l7-3.111v7.812l-7 3.11z"></path></svg>
            <span>{{__('Products')}}</span>
        </div>
    </x-sidebar-link>
    @endif
    <hr class="border border-gray-200 dark:border-gray-600 mx-2">
    {{-- User List --}}
    @if ( current_user()->can('user list') )
    <x-sidebar-link :href="route('users')" :active="request()->routeIs('users')">
        <div class="flex space-x-2 items-center">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5 fill-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
            <span>{{__('Users')}}</span>
        </div>
    </x-sidebar-link>
    @endif
    {{-- Role List --}}
    @if ( current_user()->can('role list') )
    <x-sidebar-link :href="route('roles.index')" :active="request()->routeIs('roles.index')">
        <div class="flex space-x-2 items-center">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5 fill-current"><path d="M12 14l9-5-9-5-9 5 9 5z" /><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" /></svg>
            <span>{{__('Roles')}}</span>
        </div>
    </x-sidebar-link>
    @endif
    {{-- Permission List --}}
    @if ( current_user()->can('permission list') )
    <x-sidebar-link :href="route('permissions.index')" :active="request()->routeIs('permissions.index')">
        <div class="flex space-x-2 items-center">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5 fill-current"><path d="M17.868 4.504A1 1 0 0 0 17 4H3a1 1 0 0 0-.868 1.496L5.849 12l-3.717 6.504A1 1 0 0 0 3 20h14a1 1 0 0 0 .868-.504l4-7a.998.998 0 0 0 0-.992l-4-7zM16.42 18H4.724l3.145-5.504a.998.998 0 0 0 0-.992L4.724 6H16.42l3.429 6-3.429 6z"></path></svg>
            <span>{{__('Permissions')}}</span>
        </div>
    </x-sidebar-link>
    @endif
</div>
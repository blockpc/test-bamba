@props(['params' => []])

<div x-show="showModal" class="fixed flex items-center justify-center overflow-auto z-50 bg-black bg-opacity-70 left-0 right-0 top-0 bottom-0"  
    x-transition:enter="transition ease duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
    x-cloak>
    <!-- Modal -->
    <div {{ $attributes->merge(['class' => 'bg-white text-gray-800 dark:bg-gray-800 dark:text-gray-200 rounded-xl shadow-2xl p-3 w-full md:max-w-md mx-2 md:p-4 md:mx-4 max-h-screen overflow-y-auto scrollbar-thin scrollbar-thumb-gray-600']) }} 
        x-transition:enter="transition ease duration-100 transform" x-transition:enter-start="opacity-0 scale-90 translate-y-1" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease duration-100 transform" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-90 translate-y-1">
        <!-- Title -->
        <div class="flex justify-between items-center mb-3">
            <div class="font-bold block text-lg">
                {{ $title }}
            </div>
            <button type="button" class="btn-sm text-red-400" x-on:click="showModal = false">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5 fill-current"><path d="m16.192 6.344-4.243 4.242-4.242-4.242-1.414 1.414L10.535 12l-4.242 4.242 1.414 1.414 4.242-4.242 4.243 4.242 1.414-1.414L13.364 12l4.242-4.242z"></path></svg>
            </button>
        </div>
        @foreach ($params as $key => $value)
            @php
                $class = instance_enum($key);
            @endphp
            <div class="flex justify-between items-center my-1 hover:bg-gray-300 dark:hover:bg-gray-600 p-1">
                <div class="flex flex-col w-2/3">
                    <div class="text-sm md:text-base font-semibold">{{$class->title ?? 'Cantidad de Items'}}</div>
                    <div class="text-xs">{{$class->description ?? 'Número máximo de productos en pedido'}}</div>
                </div>
                <div class="w-1/3 font-bold">
                    @if ( $class )
                        @if ( $class && $class->is_boolean )
                        <span class="ml-2">{{ $value ? 'Si' : 'No' }}</span>
                        @else
                        <span class="ml-2">{{ Str::title($value)}}</span>
                        @endif
                    @else
                    <span class="ml-2">{{ $value }}</span>
                    @endif
                </div>
            </div>
        @endforeach
        <!-- Slot -->
        <div class="flex flex-col space-y-2">
            {{ $slot }}
        </div>
    </div>
</div>
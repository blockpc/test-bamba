@props([
    'sortable' => null,
    'direction' => null,
])
<th {{ $attributes->merge(['class' => 'px-3 py-2']) }}>
    @unless ( $sortable )
        <span class="uppercase font-bold whitespace-pre">{{ $slot }}</span>
    @else
        <button type="button" class="uppercase font-bold dark:hover:text-gray-400 hover:text-gray-600">
            <div class="flex items-center space-x-1">
                <span class="flex-none">{{ $slot }}</span>
                <span>
                    @if ( $direction === 'asc')
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                        </svg>
                    @elseif ( $direction === 'desc')
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                        </svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 opacity-25 group-hover:opacity-100 transition-opacity duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                        </svg>
                    @endif
                </span>
            </div>
        </button>
    @endunless
</th>
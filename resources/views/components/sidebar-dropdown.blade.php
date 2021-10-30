@props(['align' => 'right', 'width' => '48', 'active'])

@php
switch ($align) {
    case 'left':
        $alignmentClasses = 'origin-top-left left-0';
        break;
    case 'top':
        $alignmentClasses = 'origin-top';
        break;
    case 'right':
    default:
        $alignmentClasses = 'origin-top-right right-0';
        break;
}

switch ($width) {
    case '48':
        $width = 'w-48';
        break;
    default:
        $width = 'w-64';
        break;
}

$classes = ($active ?? false)
            ? 'block py-2 px-4 transition duration-200 hover:bg-gray-200 dark:hover:bg-gray-600 border-l-2 border-blue-400 dark:border-blue-200'
            : 'block py-2 px-4 transition duration-200 hover:bg-gray-200 dark:hover:bg-gray-600';
@endphp

<div class="relative {{ $classes }}" x-data="{ open: false }" @click.away="open = false" @close.stop="open = false">
    <div @click="open = ! open">
        {{ $trigger }}
    </div>

    <div x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95"
            class="absolute z-20 mt-2 {{ $width }} rounded-md shadow-lg {{ $alignmentClasses }}"
            style="display: none;"
            @click="open = false">
        <div class="mx-1 p-1 nav-dark">
            {{ $content }}
        </div>
    </div>
</div>

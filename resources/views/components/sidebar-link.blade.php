@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block py-2 px-4 transition text-sm duration-200 hover:bg-gray-200 dark:hover:bg-gray-600 border-l-2 border-blue-400 dark:border-blue-200'
            : 'block py-2 px-4 transition text-sm duration-200 hover:bg-gray-200 dark:hover:bg-gray-600';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex flex-col items-center justify-center px-5 bg-indigo-100 border-indigo-500 border-b-8 dark:hover:bg-gray-800 group'
            : 'inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 dark:hover:bg-gray-800 group';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>

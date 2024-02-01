@props(['class'])

@php
    $classes = $class ?? 'text-slate-900 font-bold text-2xl';
@endphp

<h1 {{ $attributes->merge(['class' => $classes])}}>WM</h1>
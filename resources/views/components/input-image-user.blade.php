@props(['picture', 'model', 'active'])

@php
    $src = $picture;
    $actived = $active ?? false;
@endphp

<label for="input-file" class="flex relative ">
    <span class="absolute bottom-0  bg-white rounded-full p-2 z-10 text-5xl">
        <i class="fa-solid fa-camera"></i>
    </span>
    <img {{$attributes->merge(['src' => $src ])}} alt="{{ auth()->user()->name }}" {{ $attributes->merge(['class' => $actived ? "hover:ring-2 hover:ring-red-500 w-[200px] h-[200px] rounded-full  cursor-pointer object-cover" : "hover:ring-2 hover:ring-red-500 w-[200px] h-[200px] rounded-full opacity-80 cursor-pointer object-cover" ]) }}>

    <input type="file" id="input-file" accept="image/*" class="hidden" wire:model='{{ $model }}'>
</label>
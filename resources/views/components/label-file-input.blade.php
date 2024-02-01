@props(['for'])

<label for="{{ $for }}" class="bg-slate-900 px-3 py-1 rounded-md shadow-md cursor-pointer text-white hover:bg-slate-700">
    {{  $slot }}
</label>
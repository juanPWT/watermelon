@props(['on', 'message', 'type'])

<div 
    x-data="{ shown: false, timeout: null }"
    x-init="@this.on('{{ $on }}', () => { clearTimeout(timeout); shown = true; timeout = setTimeout(() => { shown = false }, 3000); })"
    x-show.transition.out.opacity.duration.1500ms="shown"
    x-transition:leave.opacity.duration.1500ms
    style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 9999; display: none;"
    @if ($type === 'primary')
    {{ $attributes->merge(['class' => 'flex items-center w-full max-w-xs p-4 space-x-4 rtl:space-x-reverse text-white bg-slate-900 divide-x rtl:divide-x-reverse divide-gray-200 rounded-lg shadow space-x']) }}
    @elseif ($type === 'success')
    {{ $attributes->merge(['class' => 'flex items-center w-full max-w-xs p-4 space-x-4 rtl:space-x-reverse text-slate-900 bg-green-100 divide-x rtl:divide-x-reverse divide-green-200 rounded-lg shadow space-x']) }}
    @elseif ($type === 'error')
    {{ $attributes->merge(['class' => 'flex items-center w-full max-w-xs p-4 space-x-4 rtl:space-x-reverse text-slate-900 bg-red-100 divide-x rtl:divide-x-reverse divide-red-200 rounded-lg shadow space-x']) }}
    @endif
>
    <div class="ps-4 text-sm font-normal">{{ $message }}.</div>
</div>

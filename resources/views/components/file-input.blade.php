@props(['formatType', 'name', 'model'])
<input wire:model='{{ $model }}' type="file" accept="{{ $formatType. '/*' }}" name="{{ $name}}" id="{{ $name }}" class="hidden">
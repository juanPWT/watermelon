@props(['formatType', 'src'])

@if ($formatType == 'image')
    <img src="{{ $src }}" alt="image" class="w-[100px] h-[100px] object-fill rounded-md">
@elseif ($formatType == 'video')
    <video src="{{ $src }}" class="w-full h-[400px]  object-cover rounded-md" controls></video>
@endif

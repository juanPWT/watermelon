   @props(['picture', 'name', 'content', 'created_at', 'like', 'image', 'owner'])

   @php
         $picture = $picture ?? 'default.png';
         $isOwner = $owner ?? false;
         $isImage = $image ?? false;
   @endphp

   <div class="w-full flex  gap-3">
    {{-- start --}}
    <div class="flex justify-center ">
          <img src="{{ url('storage/image/user/' . $picture) }}" default="{{ url('storage/image/user/default.png') }}" alt="user" class="w-14 h-12 sm:w-[55px] sm:h-[50px] rounded-full object-cover'">
    </div>
    <div class="flex flex-col gap-2 justify-start w-full">
          <div class="flex gap-1 items-center">
              <h1 class="text-base font-semibold text-slate-900">{{ $name ?? 'username' }}</h1>
              &#8226;
              <span class="text-xs font-light text-slate-800">{{ $created_at ?? 'now' }}</span>
              @if ($isOwner)
                  &#8226;
                  <span class="text-base font-light text-sky-500">owner</span>
              @endif
          </div>
          {{-- content comment --}}
          <p class="text-sm font-medium text-slate-800 break-words">
                {{ $content ?? 'content comment' }}  
          </p>

          {{-- image --}}
          @if ($image)
             <img src="{{ url('storage/resource/post/comment/' . $image ) }}" alt="image" class="w-40 h-40 rounded-md object-cover">     
          @endif
          

          {{-- action  --}}
          <div class="flex w-full justify-end items-center gap-5">
              <button class="text-sm font-semibold text-slate-800"><i class="fa-solid fa-thumbs-up"></i> like  {{ $like }} </button>
              <button class="text-sm font-semibold text-slate-800"><i class="fa-solid fa-comment"></i> comment</button>
          </div>
    </div>
</div>
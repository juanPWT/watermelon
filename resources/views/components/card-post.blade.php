  @props(['post_id', 'user_id', 'file','format', 'picture', 'name', 'date', 'content', 'like', 'comment'])
  
  @php

   $isFile = $file !== null && $file !== "" ? true : false;
   
 
    
  @endphp
  
  <div class="px-5  py-4 bg-white dark:bg-gray-800 shadow rounded-lg max-w-lg sm:max-w-full">
      <div class="flex mb-4 justify-between">
        <div class="flex gap-1">
          <img class="w-12 h-12 rounded-full object-cover" src="{{ url('storage/image/user/'. $picture) }}"/>
          <div class="ml-2 mt-0.5">
            <span class="block font-medium text-base leading-snug text-black dark:text-gray-100">{{ $name }}</span>
            <span class="block text-xs sm:text-sm text-gray-500 dark:text-gray-400 font-light leading-snug">{{ $date }}</span>
          </div>
        </div>
        @if ((int)$user_id === auth()->user()->id)    
          <livewire:my-post.dropdown-setting-post :post_id="$post_id" />
        @endif
      </div>
      <p class="text-gray-800 text-sm sm:text-base dark:text-gray-100 leading-snug md:leading-normal">{{ $content }}</p>
      @if ($isFile)  
          @if ($format === 'video')
            <div class="w-full my-2 flex justify-center items-center">
                <video controls="controls"  class="w-full rounded-md h-auto sm:h-[400px] sm:w-auto object-cover">
                    <source src="{{ url('storage/resource/post/' . $file) }}" type="video/mp4">
                    Your browser does not support the video tag. 
                </video>
            </div>
          @elseif ($format === 'image') 
            <div class="w-full my-2 flex justify-center items-center">
              <img src="{{ url('storage/resource/post/' . $file ) }}" alt="post" class="w-full rounded-md h-auto sm:h-[400px] sm:w-auto object-cover">
          </div>
          @endif
      @endif
      <div class="flex justify-between items-center mt-5">
      <livewire:my-post.like-post :post_id='$post_id' :user_id='$user_id' :likes='$like' />
      <livewire:my-post.comment-post :totalComment="$comment" :post_id="$post_id">
      </div>
  </div>
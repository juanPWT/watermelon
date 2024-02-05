<?php

use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use App\Models\Post;

new class extends Component {
    
    use WithFileUploads;
    
    public $content;
    public $image;
    public $video;

     function postNews() {

        $data = [];

        $this->validate([
            'content' => 'required|min:10',
            'image' => 'nullable|image|max:1024',
            'video' => 'nullable|mimes:mp4|max:10024',
        ]);

        if ($this->image && $this->video) {
            //error
            $this->dispatch('illegal_file_input_toast');
            $this->dispatch('illegal_file_input');
            return;
        }

        $file = null;
        $format = null;

        if ($this->image) {
            $format = 'image';
            $file = $this->image->hashName();
        }else if ($this->video) {
            $format = 'video';
            $file = $this->video->hashName();
        }

        $data= [
            'user_id' => auth()->user()->id,
            'content' => $this->content,
            'format' => $format,
            'file' => $file,
        ];

        Post::create($data);

        if ($this->image) {
            $this->image->storeAs('public/resource/post', $file);
        } else if ($this->video) {
            $this->video->storeAs('public/resource/post', $file);
        }
        // Reset input setelah posting berhasil
        $this->reset('content', 'image', 'video');

        
        $this->dispatch('saved');
        $this->dispatch('saved_toast');

        return redirect(request()->header('Referer'));
    }
}

?>


<div class="w-full p-6 flex flex-col justify-center items-center">
    {{-- toast  --}}
    <x-action-toast on="illegal_file_input_toast" message="cannot 2 diffrent type in 1 post (in development)" type="primary" />
    <x-action-toast on="saved_toast" message="your news was posted" type="success" />

    <div class="flex w-full justify-center items-center">
        <input  x-on:focus.prevent="$dispatch('open-modal', 'post-news-palestine')" type="text" class="py-3 px-10 w-full sm:w-1/4 text-slate-900 rounded-l-full placeholder:text-xs placeholder:text-slate-400 cursor-pointer" placeholder="post news about palestine, today?" >
        <button  x-on:click.prevent="$dispatch('open-modal', 'post-news-palestine')"  class="bg-slate-900 text-white py-3 px-7 rounded-r-full"><i class="fa-solid fa-paper-plane"></i></button>
    </div>
    <x-modal name="post-news-palestine" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit='postNews' class="bg-white p-5 flex flex-col">
            <div class="w-full">
                <x-input-label for="content" :value="__('Content')" />
                <x-textarea-input wire:model='content' id="content" name="content" rows="5" class="mt-1 block w-full" required autofocus autocomplete="caption" />
                <x-input-error class="mt-2" :messages="$errors->get('content')" />
            </div>
            <div class="w-full my-2 flex items-center justify-start gap-4">
                <div>
                    <x-label-file-input for="image">
                            <i class="fa-solid fa-image"></i>
                    </x-label-file-input>
                    <x-file-input :model="'image'" name="image" formatType="image"/>
                </div>
                <div>
                    <x-label-file-input for="video">
                        <i class="fa-solid fa-video"></i>
                    </x-label-file-input>
                    <x-file-input :model="'video'" name="video" formatType="video"/>
                </div>
            </div>

            {{-- patch illegal condition --}}
            <x-action-error-message class="mr-3" on="illegal_file_input">
                {{ __('sorry not support 2 file in 1 post (in development)') }}
            </x-action-error-message>

            @error('image')
                <div class="text-red-500 mt-2 text-sm">
                    {{ $message }}
                </div>
            @enderror
            @error('video')
                <div class="text-red-500 mt-2 text-sm">
                    {{ $message }}
                </div>
            @enderror
            <div class="my-2 w-full">
                @if ($image)   
                    <x-preview-file-input formatType="image" :src="$image->temporaryUrl()" />
                @endif
                @if ($video)   
                    <x-preview-file-input formatType="video" :src="$video->temporaryUrl()" />
                @endif
            </div>
            <div class="flex justify-end items-center mt-4">
                <x-action-message class="mr-3" on="saved">
                    {{ __('news was posted') }}
                </x-action-message>
                <x-primary-button  class="ml-4">
                    {{ __('Post') }}
                </x-button>
            </div>
        </form>
    </x-modal>
</div>

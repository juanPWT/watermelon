<?php

    use Livewire\Volt\Component;
    use App\Models\Post;

    new class extends Component {

        public $post_id;

        public function mount($post_id)
        {
            $this->post_id = $post_id;
        }

        function deletePost() {
            $validateOwner = Post::where('id', $this->post_id)->where('user_id', auth()->user()->id)->first();

            if (!$validateOwner) {
                $this->dispatch('illegal-stuff');
                return;
            }


            $post = Post::find($this->post_id);
            $post->delete();

            //unlink file
            if ($post->file !== null && $post->file !== "") {
                unlink(storage_path('app/public/resource/post/' . $post->file));
            }

            $this->dispatch('success-delete-post');

        }
      
    }
?>


<div class="flex justify-center items-center">
    {{-- toast --}}
    <x-action-toast on="illegal-stuff" message="your detected in illegal stuff your cannot delete this" type="error"/>
    <x-action-toast on="success-delete-post" message="success deleteing your post" type="primary" />

    <x-dropdown  :align="'right'" width="48">
        <x-slot name="trigger">
            {{-- hambuger setting post --}}
            <button type="button" class="rounded-md py-2 px-4 hover:bg-gray-100">
              <i class="fa-solid fa-ellipsis-vertical text-xl"></i>
            </button>
        </x-slot>
        <x-slot name="content">
            <div class="bg-white p-2">
                <x-dropdown-link wire:click='deletePost' class="text-red-500">
                    <i class="fa-solid fa-trash"></i>
                    {{ __('delete') }}
                </x-dropdown-link>
            </div>
        </x-slot>
    </x-dropdown>
  </div>
<?php 

    use Livewire\Volt\Component;
    use App\Models\Comment;
    use App\Models\Post;

    new class extends Component {

        public $totalComment;
        public $post_id;

        // for create
        public $content;


        // for read
        public $dataComment;


        public function mount($totalComment, $post_id)  {
            $this->totalComment = $totalComment;
            $this->post_id = $post_id;

            $this->dataComment = Comment::join('users', 'users.id', '=', 'comments.user_id')
            ->join('posts', 'posts.id', '=', 'comments.post_id')
            ->where('comments.post_id', $this->post_id)
            ->select('users.picture', 'users.name', 'users.id as userId', 'posts.user_id as post_userId', 'comments.*')->get();

        }

         function commentPost() {

            $this->validate([
                'content' => 'required|string|max:255',
             ]);

            // create comment
            $data = [
                'user_id' => auth()->user()->id,
                'post_id' => $this->post_id,
                'content' => $this->content,
            ];

            if (Comment::create($data)) {

                // update total comment post
                $post = Post::find($this->post_id);
                $post->comment = $this->totalComment + 1;
                $post->save();
                
                $this->dispatch('success_comment');
            }else {
                $this->dispatch('error_comment');
            }
            
            
            $this->reset('content');
        }


    }

?>

<x-modal-footer>

    <x-slot name="utility">
        <x-action-toast on="success_comment" message="comment posted" type="primary" />
        <x-action-toast on="error_comment" message="something wrong" type="error" />
    </x-slot>

    <x-slot name="trigger">
      <button class="ml-1 text-gray-500 dark:text-gray-400 font-light">{{ $totalComment }} comments</button>
    </x-slot>

    <x-slot name="header">
      <h1>{{ $totalComment }} Comment</h1>
         {{-- error --}}
         @error('content')
         <span class="text-xs text-red-500 text-center">{{ $message }}</span>
         @enderror
 
    </x-slot>

    <x-slot name="content">
        {{-- comment  --}}
        <div class="hidden sm:flex w-full p-2 bg-white">
            <form wire:submit.prevent='commentPost' class="flex w-full justify-center gap-2">
                <input type="text" wire:model='content' class="w-full rounded-full px-4  text-sm ring-slate-900 focus:ring-red-500">
                <button type="submit" class="px-3 py-2 text-2xl hover:bg-gray-100 rounded-full text-slate-900">
                    <i class="fa-regular fa-paper-plane"></i>
                </button>
            </form>
        </div>

        {{-- content comment  --}}
        <div class="px-4 pt-4 pb-40 sm:pb-14 grid grid-cols-1 gap-3 bg-white h-full overflow-y-scroll">
            @foreach ( $dataComment as $key => $data )

            @php
                // time diff
                $currentTime = time();
                $dataTime = strtotime($data['created_at']);
                $diffTime = $currentTime - $dataTime;
                $minute = round($diffTime / 60);
                $timeDiff = $minute <= 0 ? 'now' : $minute . ' min ago';

                // is owner
                $isOwner = $data['userId'] == $data['post_userId'] ? true : false;
            @endphp
            <x-card-comment
            name="{{ $data['name'] }}"
            picture="{{ $data['picture'] }}"
            content="{{ $data['content'] }}"
            created_at="{{ $timeDiff }}"
            owner="{{ $isOwner }}"
            /> 
                
            @endforeach
        </div>

        {{-- responsive form --}}
        <div class="fixed bottom-0 sm:hidden w-full bg-white  p-4">
            <form wire:submit.prevent='commentPost' class="flex w-full justify-center gap-2">
                <input type="text" wire:model='content' class="w-full rounded-full px-4  text-sm ring-slate-900 focus:ring-red-500">
                <button type="submit" class="px-3 py-2 text-2xl hover:bg-gray-100 rounded-full text-slate-900">
                    <i class="fa-regular fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </x-slot>
  </x-modal-footer>
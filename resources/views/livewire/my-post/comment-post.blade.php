<?php 

    use Livewire\Volt\Component;
    use Livewire\WithFileUploads;
    use App\Models\Comment;
    use App\Models\Post;

    new class extends Component {

        use WithFileUploads;

        public $totalComment;
        public $post_id;

        // for create
        public $content;
        public $image;


        // for read
        public $dataComment;


        public function mount($totalComment, $post_id)  {
            $this->totalComment = $totalComment;
            $this->post_id = $post_id;

            $this->loadComments();

        }

        function loadComments() {

            $this->dataComment = Comment::join('users', 'users.id', '=', 'comments.user_id')
            ->join('posts', 'posts.id', '=', 'comments.post_id')
            ->where('comments.post_id', $this->post_id)
            ->select('users.picture', 'users.name', 'users.id as userId', 'posts.user_id as post_userId', 'comments.*')->get();
        
        }


         function commentPost() {

            $this->validate([
                'content' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1048'
             ]);

            // create comment
            $data = [
                'user_id' => auth()->user()->id,
                'post_id' => $this->post_id,
                'content' => $this->content,
                'image'   => !$this->image ? null : $this->image->getClientOriginalName()   
            ];

            if (Comment::create($data)) {

                // update total comment post
                $post = Post::find($this->post_id);
                $post->comment = $this->totalComment + 1;
                $post->save();

                // store image
                if ($this->image) {
                    $this->image->storeAs('public/resource/post/comment', $this->image->getClientOriginalName());
                }
                
                $this->dispatch('success_comment');
            }else {
                $this->dispatch('error_comment');
            }
            
            
            $this->reset('content', 'image');
            $this->loadComments();

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
        <div class="hidden sm:flex sm:flex-col w-full p-2 bg-white">
            <form wire:submit.prevent='commentPost' class="flex w-full justify-center gap-2">
                <input type="text" wire:model='content' class="w-full rounded-full px-4  text-sm ring-slate-900 focus:ring-red-500">
                <label for="include-image" class="flex justify-center items-center text-xl cursor-pointer hover:scale-110">
                    <i class="fa-regular fa-image text-gray-500"></i>
                </label>
                <button type="submit" class="px-3 py-2 text-2xl hover:bg-gray-100 rounded-full text-slate-900">
                    <i class="fa-regular fa-paper-plane"></i>
                </button>
            </form>

            @if ($image)
            {{-- preview image  --}}
            <div class="flex w-full justify-between p-2 ">
                <span class="text-sm text-slate-600">{{ $image->getClientOriginalName() }}</span>
                <img src="{{ $image->temporaryUrl() }}" alt="preview-image" class="w-10 h-10 rounded-md object-cover">
            </div>
            @endif

        </div>

        {{-- content comment  --}}
        <div class="px-4 pt-4 pb-44 sm:pb-20 grid grid-cols-1 gap-3 bg-white h-full overflow-y-scroll">
            {{-- if dataComment 0  --}}
            @if (count($dataComment) <= 0 )
                <div class="w-full min-h-full flex flex-col gap-3 justify-center items-center">
                    <p class="text-2xl text-slate-600">NOTHING!!</p>
                    <p class="text-base font-semibold text-slate-800">comment is empty.</p>
                </div>
            @endif

            @foreach ( $dataComment as $key => $data )

            @php
                // time diff
                $currentTime = time();
                $dataTime = strtotime($data['created_at']);
                $diffTime = $currentTime - $dataTime;
                $minute = round($diffTime / 60);
                $timeDiff = $minute <= 0 ? 'now' : $minute . ' min ago';

                $timeResult = $minute >= 20 ? date('d M Y h:i', strtotime($data['created_at'])) : $timeDiff;

                // is owner
                $isOwner = $data['userId'] == $data['post_userId'] ? true : false;
            @endphp
            <x-card-comment
            name="{{ $data['name'] }}"
            picture="{{ $data['picture'] }}"
            content="{{ $data['content'] }}"
            created_at="{{ $timeResult }}"
            owner="{{ $isOwner }}"
            like="{{ $data['like'] }}"
            image="{{ $data['image'] }}"
            /> 
                
            @endforeach
        </div>

        {{-- responsive form --}}
        <div class="fixed bottom-0 sm:hidden w-full bg-white  p-4">
            @if ($image)
            {{-- preview image  --}}
            <div class="flex w-full justify-between p-2 ">
                <span class="text-sm text-slate-600">{{ $image->getClientOriginalName() }}</span>
                <img src="{{ $image->temporaryUrl() }}" alt="preview-image" class="w-10 h-10 rounded-md object-cover">
            </div>
            @endif
            <form wire:submit.prevent='commentPost' class="flex w-full justify-center gap-2">
                <input type="text" wire:model='content' class="w-full rounded-full px-4  text-sm ring-slate-900 focus:ring-red-500">
                <label for="include-image" class="flex justify-center items-center text-xl cursor-pointer hover:scale-110">
                    <i class="fa-regular fa-image text-gray-500"></i>
                    <input type="file" accept="image/*" id="include-image" wire:model='image' class="hidden">
                </label>
                <button type="submit" class="px-3 py-2 text-2xl hover:bg-gray-100 rounded-full text-slate-900">
                    <i class="fa-regular fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </x-slot>
  </x-modal-footer>
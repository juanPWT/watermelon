<?php

    use Livewire\Volt\Component;
    use App\Models\Post;
    use App\Models\Like;

    new class extends Component {

        public $post_id;
        public $user_id;
        public $likes;

        // animtion like
        public $showLike = false;

        //users has already like post
        public $usersLikes;

        function vlidateUseralreaadylike() {

            $ifUserLike = Like::where('post_id', $this->post_id)->where('user_id', auth()->user()->id)->first();

            if ($ifUserLike) {
                return true;
            }else {
                return false;
            }
        }

        function likePost()
        {
            //validtion user already like post
            $ifUserLike = $this->vlidateUseralreaadylike();


            if ($ifUserLike)  {
                $this->showLike = true;
                return;
            }

            Like::create([
                'post_id' => $this->post_id,
                'user_id' => auth()->user()->id
            ]);

            //update likes post
            Post::where('id', $this->post_id)->increment('like');


            $this->likes++;
            $this->showLike = true;
            $this->usersLike();
        }

        function usersLike() {
            
            $this->usersLikes = Like::join('users', 'users.id', '=', 'likes.user_id')->where('post_id', $this->post_id)->take(3)->get();

        }



        public function mount($post_id, $user_id, $likes)
        {
            $this->post_id = $post_id;
            $this->user_id = $user_id;
            $this->likes = $likes;

            $this->showLike = $this->vlidateUseralreaadylike();

            $this->usersLike();
        }
        

    }

?>

<div class="flex gap-3 justify-center items-center">
    <button wire:click='likePost' class="flex gap-2 cursor-pointer">
        @if ($showLike )
            <i  class="fa-solid fa-thumbs-up my-auto text-xl"></i>
        @else
            <i class="fa-regular fa-thumbs-up my-auto text-xl"></i>
        @endif
        <span class="ml-1 text-gray-500 dark:text-gray-400  font-semibold">{{ $likes }}</span>
    </button>  
        {{-- priview user like --}}
        <div class="flex items-center overflow-hidden">
            @if (count($usersLikes) <= 0)
                @php
                    null;
                @endphp
            @else
                @foreach ($usersLikes as $key => $data)
                    <img class="inline-block h-6 w-6 rounded-full text-white border-2 border-white object-cover object-center" src="{{ url('storage/image/user/' . $data['picture']  ) }}" alt="userLike">
                @endforeach
            @endif
        </div>
</div>
<?php 
    use Livewire\Volt\Component;
    use App\Models\Post;

    new class extends Component {
        
        public $dataPost;
    
        public function mount()
        {
        
            $this->dataPost = Post::join('users', 'users.id', '=', 'posts.user_id')->where('posts.user_id', auth()->user()->id)->orderBy('posts.created_at', 'DESC')->select('users.name', 'users.picture', 'posts.*')->get();
            
        }
       
       
        }
?>

<div class="w-full grid grid-cols-1 justify-center items-center gap-3 min-h-screen px-6 pb-6">
    @foreach ( $dataPost as $key => $data)       
    <div class="w-full mx-auto">
        <x-card-post
         post_id="{{ $data['id'] }}"
         user_id="{{ $data['user_id'] }}"
         name="{{ $data['name'] }}" 
         picture="{{ $data['picture'] }}" 
         file="{{ $data['file'] }}"
         format="{{ $data['format'] }}"
         date="{{ date( 'd F Y h:i', strtotime($data['created_at'])) }}"
         content="{{ $data['content'] }}"
         like="{{ $data['like'] }}"
         comment="{{ $data['comment'] }}"
         />
    </div>
@endforeach
</div>

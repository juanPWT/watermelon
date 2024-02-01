<?php
 use App\Models\User;
 use Livewire\WithFileUploads;
 use Livewire\Volt\Component;

 new class extends Component {

    use WithFileUploads;

    public $picture;

  
    function updatePicture() {

        
        $this->validate([
            'picture' => 'image|max:1024', // 1MB Max
        ]);

        $name_file = auth()->user()->id . "_" . date("Ymd_his") . '.' . $this->picture->extension();

        $user = User::find(auth()->user()->id);

        //update picture
        if ($user->update(['picture' => $name_file])) {
            //if exist picture
            if (Storage::get('public/image/user/' . auth()->user()->picture) && auth()->user()->picture != 'default.png') {
                //delete picture
                Storage::delete('public/image/user/' . auth()->user()->picture);

                //alert
                session()->flash('success_updated_user_picture', 'Picture updated successfully.');
                $this->dispatch('update-picture');
                
                //save picture
                $this->picture->storeAs('public/image/user', $name_file);

            }else {

                //alert
                session()->flash('success_updated_user_picture', 'Picture updated successfully.');
                $this->dispatch('update-picture');

                //save picture
                $this->picture->storeAs('public/image/user', $name_file);
            }
        }


    }


 }

?>

<section>
    <header class="flex gap-2 items-center">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Picture') }}
        </h2>
        <x-action-message class="me-3" on="update-picture">
            {{ __('edited picture.') }}
        </x-action-message>
    </header>

    <x-action-toast on="update-picture" message="your profile picture is updated" type="primary" />

    <form wire:submit='updatePicture' class="flex flex-col gap-5">
        <div class="w-full flex justify-center items-center">
            @if ($picture)
                <x-input-image-user :picture="$picture->temporaryUrl()" :model="'picture'" :active="true" />
            @else
                <x-input-image-user :picture="'storage/image/user/' . auth()->user()->picture" :model="'picture'" />
            @endif
        </div>

        {{-- error --}}
        @error('picture')
        <span class="text-base text-red-500 text-center">{{ $message }}</span>
        @enderror

        <div class="flex justify-center items-center w-full ">
            <x-primary-button>
                {{ __('Save') }}
            </x-primary-button>
        </div>
    
    </form>
</section>
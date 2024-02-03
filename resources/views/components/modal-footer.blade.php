<div class="relative" x-data="{ show: false }">
    <div @click="show = !show">
        <!-- Trigger modal -->
        {{ $trigger }}
    </div>
    <div x-show="show"
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="translate-y-full opacity-0"
         x-transition:enter-end="translate-y-0 opacity-100"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="translate-y-0 opacity-100"
         x-transition:leave-end="translate-y-full opacity-0"
         class="fixed inset-0 z-50 overflow-hidden flex items-center justify-center"
         style="display: none;"
    >
        {{-- utility  --}}
        {{ $utility }}
        <!-- Background overlay -->
        <div class="absolute inset-0 bg-gray-500 bg-opacity-75 dark:bg-gray-900 dark:bg-opacity-75" @click="show = false"></div>

        <!-- Modal content -->
        <div class="fixed bottom-0 sm:static sm:bottom-auto  w-full sm:max-w-lg max-h-[70%] h-full z-50">
            <!-- Modal header -->
            <div class="px-4 py-2 bg-slate-900 text-white font-semibold  rounded-t-lg">
                {{ $header }}
            </div>
        
            <!-- Content -->
            {{ $content }}
        </div>        
    </div>
</div>

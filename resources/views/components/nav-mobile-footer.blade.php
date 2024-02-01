
<div class="sm:hidden flex fixed bottom-0 left-0 z-40 w-full h-16 bg-white border-t border-gray-200 dark:bg-gray-700 dark:border-gray-600">
    <div class="grid  h-full w-full grid-cols-3 mx-auto font-medium">
        <x-nav-link-foot :href="route('dashboard')" :active="request()->routeIs('dashboard')">     
            <i class="fa-solid fa-home"></i>
            <span class="text-sm text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-500">Home</span>
        </x-nav-link-foot>    
        <x-nav-link-foot>     
            <i class="fa-solid fa-fire"></i>
            <span class="text-sm text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-500">Tranding</span>
        </x-nav-link-foot>    
        <x-nav-link-foot :href="route('profile')" :active="request()->routeIs('profile')">     
            <i class="fa-solid fa-user"></i>
            <span class="text-sm text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-500">Profile</span>
        </x-nav-link-foot>    
    </div>
</div>

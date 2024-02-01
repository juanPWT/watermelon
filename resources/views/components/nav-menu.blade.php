@props(['title'])

<section class=" p-4 flex flex-col gap-6 w-full h-auto">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __($title) }}
        </h2>
    </header>
    <div class="w-full grid grid-cols-1 gap-3">
        {{ $slot }}
    </div>
</section>
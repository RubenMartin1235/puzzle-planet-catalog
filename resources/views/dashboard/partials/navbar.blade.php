<nav class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-row flex-wrap items-center justify-items-center ">
    <x-nav-link :href="route('dashboard.planets')" class="px-6 py-2 items-center justify-items-center text-lg">
        {{ __('Planets') }}
    </x-nav-link>
    <x-nav-link :href="route('dashboard.comments')" class="px-6 py-2 items-center justify-items-center text-lg">
        {{ __('Comments') }}
    </x-nav-link>
    <x-nav-link :href="route('dashboard.cards')" class="px-6 py-2 items-center justify-items-center text-lg">
        {{ __('Cards') }}
    </x-nav-link>
</nav>

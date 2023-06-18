<nav class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-row flex-wrap items-center justify-items-center ">
    @if (Auth::user()->hasRole('admin'))
        <x-nav-link :href="route('dashboard.users')"
        class="text-red-600 px-6 py-2 items-center justify-items-center text-lg">
            {{ __('Users') }}
        </x-nav-link>
        <x-nav-link :href="route('dashboard.purchases')"
        class="text-red-600 px-6 py-2 items-center justify-items-center text-lg">
            {{ __('Purchases') }}
        </x-nav-link>
    @endif
    @if (Auth::user()->hasAnyRole(['loader','admin']))
        <x-nav-link :href="route('dashboard.cards-admin')"
        class="text-green-600 px-6 py-2 items-center justify-items-center text-lg">
            {{ __('Cards') }}
        </x-nav-link>
    @endif
    <x-nav-link :href="route('dashboard.planets')" class="px-6 py-2 items-center justify-items-center text-lg">
        {{ __('My Planets') }}
    </x-nav-link>
    <x-nav-link :href="route('dashboard.comments')" class="px-6 py-2 items-center justify-items-center text-lg">
        {{ __('My Comments') }}
    </x-nav-link>
    <x-nav-link :href="route('dashboard.cards')" class="px-6 py-2 items-center justify-items-center text-lg">
        {{ __('My Collection') }}
    </x-nav-link>
</nav>

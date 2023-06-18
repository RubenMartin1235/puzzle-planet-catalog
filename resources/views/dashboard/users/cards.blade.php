<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('dashboard') }}"
            class="text-gray-500"
            >{{ __('Dashboard') }}</a>
            / <a href="{{ route('dashboard.users') }}"
            class="text-gray-500"
            >{{ __('Users') }}</a>
            / {{ __('Cards collected by ') }}<a href="{{ route('profile.show', $user) }}"
            class="underline"
            >{{ $user->name }}</a>
        </h2>
    </x-slot>
    @include('dashboard.partials.navbar')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('dashboard.cards.partials.cards-table')
            {{ $cards->links() }}
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('dashboard') }}"
            class="text-gray-500"
            >{{ __('Dashboard') }}</a>
            / {{ __('Purchases') }}
        </h2>
    </x-slot>
    @include('dashboard.partials.navbar')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('dashboard.purchases.partials.purchases-table')
            {{ $purchases->links() }}
        </div>
    </div>
</x-app-layout>

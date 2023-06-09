<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('planets.index') }}"
            class="text-gray-500"
            >{{ __('Profile') }}</a>
            / {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h2 class="text-2xl font-bold py-3">
                        {{ __("Planets made by ") . $user->name }}
                    </h2>
                </div>
                @include('planets.partials.planetlist')
            </div>
        </div>
    </div>
</x-app-layout>

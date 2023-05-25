<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Planets') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('planets.create') }}">
                <x-primary-button class="mt-4">
                    {{ __('Create') }}
                </x-primary-button>
            </a>
         </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
           @include('planets.partials.planetlist')
        </div>
    </div>
</x-app-layout>

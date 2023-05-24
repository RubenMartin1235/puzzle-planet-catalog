<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Planets') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid gap-4 grid-cols-3">
                @foreach ($planets as $pl)
                    <a
                    href="{{ route('planets.show', $pl) }}"
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-3 text-gray-900 flex flex-col">
                        <h4 class="text-lg font-bold text-center">{{ $pl->name }}</h4>
                        <p class="text-sm text-gray-700">{{ $pl->bio }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>

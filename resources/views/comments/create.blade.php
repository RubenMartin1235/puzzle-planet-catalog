<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('planets.index') }}"
            class="text-gray-500"
            >{{ __('Planets') }}</a>
            / <a href="{{ route('planets.show', $pl) }}"
            class="text-gray-500"
            >{{ $pl->name }}</a>
            / {{ __('Post comment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col">
                @include('planets.partials.planetlistitem')
                <form
                method="POST"
                action="{{ route('planets.comments.store', $pl) }}"
                class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-3
                text-gray-900 flex flex-col gap-3"
                >
                    @csrf
                    <textarea
                        name="message"
                        maxlength="128" required
                        placeholder="{{ __('Write your comment here!') }}"
                        class="block w-full text-lg text-gray-800 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    ></textarea>
                    <x-input-error :messages="$errors->get('message')" class="mt-2" />
                    <div class="grow grid gap-2 grid-cols-2
                    grid-cols-[repeat(2,1fr)]" id="actionbtns">
                        <x-primary-button class="mt-4 text-xl">{{ __('Post comment') }}</x-primary-button>
                        <a href="{{ url()->previous() }}">
                            <x-primary-button type="button" class="w-full mt-4 text-xl bg-gray-400 hover:bg-gray-300 text-black">{{ __('Cancel') }}</x-primary-button>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

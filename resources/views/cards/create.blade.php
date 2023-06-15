<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('cards.index') }}"
            class="text-gray-500"
            >{{ __('Cards') }}</a>
            / {{ __('Create card') }}
        </h2>
    </x-slot>

    <div class="py-12 mb-[20vh]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col">
                <form
                method="POST"
                action="{{ route('planets.store') }}"
                class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-3
                text-gray-900 flex flex-col gap-3"
                enctype="multipart/form-data"
                >
                    @csrf
                    <input class="text-3xl font-bold text-center">
                    <div class="flex md:flex-row flex-col gap-6 p-6">
                        <div class="md:w-2/6 w-full">
                        </div>
                        <div class="grow flex flex-col">
                            <p class="text-lg text-left px-6 text-gray-800">
                                <textarea
                                    name="description"
                                    maxlength="1024" required
                                    placeholder="{{ __('Enter a description for this card') }}"
                                    class="block w-2/6 text-md text-gray-800 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                >{{ old('bio') }}</textarea>
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

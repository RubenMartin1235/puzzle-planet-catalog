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
                action="{{ route('cards.update', $cd) }}"
                class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-3
                text-gray-900 flex flex-col gap-3"
                enctype="multipart/form-data"
                >
                    @csrf
                    @method('PUT')
                    <x-input-error :messages="$errors->get('message')" class="mt-2" />
                    <input
                        name="name"
                        type="text" required
                        placeholder="{{ __('Enter card name here') }}"
                        maxlength="40"
                        class="block w-full text-3xl font-bold text-center border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mb-2"
                        value="{{ old('name',$cd->name) }}"
                    >
                    <div class="flex md:flex-row flex-col gap-6 p-6">
                        <div class="md:w-2/6 w-full">
                            @include('cards.partials.editor_imginput')
                            @include('cards.partials.cardimg')
                        </div>
                        <div class="grow flex flex-col">
                            <div class="flex flex-row">
                                <input
                                    name="price"
                                    type="number" required
                                    placeholder="{{ __('Price') }}"
                                    min="0.49"
                                    max="999.99"
                                    step="0.01"
                                    class="block w-full text-2xl font-bold border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mb-2"
                                    value="{{ old('price',$cd->price) }}"
                                >
                                <input
                                    name="stock"
                                    type="number" required
                                    placeholder="{{ __('Initial stock') }}"
                                    min="1"
                                    class="block w-full text-2xl font-bold border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mb-2"
                                    value="{{ old('stock',$cd->stock) }}"
                                >
                            </div>
                            <textarea
                                name="description"
                                maxlength="1000" required
                                placeholder="{{ __('Enter a description for this card') }}"
                                class="block w-full grow text-md text-gray-800 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                            >{{ old('description',$cd->description) }}</textarea>
                        </div>
                    </div>
                    <x-primary-button class="mt-4 !text-2xl">{{ __('Edit card') }}</x-primary-button>
                </form>
            </div>
        </div>
    </div>
    <script src="{{ asset('scripts/cardeditor.js') }}"></script>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('planets.index') }}"
            class="text-gray-500"
            >{{ __('Planets') }}</a>
            / Edit planet
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col">
                <form
                method="POST"
                action="{{ route('planets.update', $pl) }}"
                class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-3
                text-gray-900 flex flex-col gap-3"
                enctype="multipart/form-data"
                >
                    @csrf
                    @method("PUT")
                    <input
                        name="name"
                        type="text" required
                        value="{{ $pl->name }}"
                        placeholder="{{ __('Enter planet name here') }}"
                        maxlength="24"
                        class="block w-full text-3xl font-bold text-center border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mb-2"
                    >
                    <div class="flex flex-row gap-6 p-6">
                        <div class="w-1/6 form-control overflow-hidden">
                            @include('planets.partials.planeteditor_imginput')
                            @include('planets.partials.planetimg')
                        </div>
                        <textarea
                            name="bio"
                            maxlength="128" required
                            placeholder="{{ __('Enter a short bio for your planet (128 characters max)') }}"
                            class="block w-2/6 text-md text-gray-800 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        >{{ $pl->bio }}</textarea>
                        <div class="w-3/6">
                            <label for="blocks-maxrate" class="text-sm">
                                Max value in sliders:
                                <input type="number" id="blocks-maxrate"
                                    maxlength="16" placeholder="Max value for sliders"
                                    class="text-sm" value="200" max="10000" min="50"
                                >
                            </label>

                            <div class="grow grid gap-2 grid-cols-4
                            grid-cols-[20%_1fr_3rem_3rem]" id="blocklist">
                                <!--
                                <select name="block-1-type" required>
                                    @foreach ($allblocks as $bl)
                                        <option value="{{ $bl->name }}">
                                            {{ $bl->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="range" name="block-1-rate" max="10000" min="1">
                                <x-danger-button id="btn-delblock"
                                    class="text-center text-2xl font-bolder"
                                    type="button"
                                >{{ __('-') }}</x-danger-button>
                                -->
                            </div>
                            <x-primary-button id="btn-addblock"
                                class="text-center text-4xl"
                                type="button"
                            >{{ __('+') }}</x-primary-button>
                        </div>
                    </div>
                    <textarea
                        name="description"
                        maxlength="1000" required
                        placeholder="{{ __('Enter a detailed description for your planet (1000 characters max)') }}"
                        class="text-md text-gray-600 p-6 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    >{{ $pl->description }}</textarea>
                    <x-input-error :messages="$errors->get('message')" class="mt-2" />
                    <div class="grow grid gap-2 grid-cols-2
                    grid-cols-[repeat(2,1fr)]" id="actionbtns">
                        <x-primary-button class="mt-4 text-xl">{{ __('Apply changes') }}</x-primary-button>
                        <a href="{{ url()->previous() }}">
                            <x-primary-button type="button" class="w-full mt-4 text-xl bg-gray-400 hover:bg-gray-300 text-black">{{ __('Cancel') }}</x-primary-button>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('planets.partials.planeteditor_initvars')
    <script src="{{ asset('scripts/planeteditor.js') }}"></script>
</x-app-layout>

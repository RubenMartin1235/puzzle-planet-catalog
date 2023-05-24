<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('planets.index') }}"
            class="text-gray-500"
            >{{ __('Planets') }}</a>
            / {{ $pl->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col">
                <div
                class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-3
                text-gray-900 flex flex-col gap-3"
                >
                    <h4 class="text-3xl font-bold text-center">{{ $pl->name }}</h4>
                    <div class="flex flex-row gap-6 p-6">
                        <div class="w-[30%]">
                            <img src="https://picsum.photos/seed/picsum/64/64"
                            class="w-[100%]">
                        </div>
                        <p class="w-[40%] text-lg text-gray-800">{{ $pl->bio }}</p>
                        <div class="grow">
                            @foreach ($blocks as $block)
                                <div class="grow grid gap-4 grid-cols-2
                                grid-cols-[20%_1fr]">
                                    <p id="block-label-{{ strtolower($block->name) }}"
                                    >{{ $block->name }}</p>
                                    <div id="block-barcontainer-{{ strtolower($block->name) }}"
                                    data-rate = {{ $block->pivot->rate }}
                                    data-color = "{{ $block->color }}"
                                    >
                                        <div></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <p class="text-md text-gray-600 p-6">{{ $pl->description }}</p>
                </div>
            </div>
        </div>
    </div>
    <script>
        let barconts = document.querySelectorAll(`[id^='block-barcontainer-']`);
        let ceilrate = 0;
        for (const bc of barconts) {
            let rate = parseFloat(bc.dataset.rate)
            ceilrate = rate > ceilrate ? rate : ceilrate;
        }
        for (const bc of barconts) {
            let rate = bc.dataset.rate;
            let bar = bc.querySelector('div');
            bar.style.width = `calc(100% / ${ceilrate / rate})`;
            bar.style.height = `80%`;
            bar.style.backgroundColor = bc.dataset.color;
        }
    </script>
</x-app-layout>

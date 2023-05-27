<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('planets.index') }}"
            class="text-gray-500"
            >{{ __('Planets') }}</a>
            / Create planet
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col">
                <form
                method="POST"
                action="{{ route('planets.store') }}"
                class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-3
                text-gray-900 flex flex-col gap-3"
                >
                    @csrf
                    <input
                        name="name"
                        type="text" required
                        placeholder="{{ __('Enter planet name here') }}"
                        maxlength="24"
                        class="block w-full text-3xl font-bold text-center border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mb-2"
                    >
                    <div class="flex flex-row gap-6 p-6">
                        <div class="w-1/6 form-control overflow-hidden">
                            <input type="file" name="image" class="form-control-file">
                            <img
                                src="https://picsum.photos/seed/picsum/64/64"
                                class="w-full"
                            >
                        </div>
                        <textarea
                            name="bio"
                            maxlength="128" required
                            placeholder="{{ __('Enter a short bio for your planet (128 characters max)') }}"
                            class="block w-2/6 text-md text-gray-800 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        >{{ old('bio') }}</textarea>
                        <div class="w-3/6">
                            <label for="blocks-maxrate" class="text-sm">
                                Max value in sliders:
                                <input type="number" id="blocks-maxrate"
                                    maxlength="16" placeholder="Max value for sliders"
                                    class="text-sm" value="200" max="10000" min="1"
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
                    >{{ old('description') }}</textarea>
                    <x-input-error :messages="$errors->get('message')" class="mt-2" />
                    <x-primary-button class="mt-4 text-2xl">{{ __('Create planet') }}</x-primary-button>
                </form>
            </div>
        </div>
    </div>
    <script>
        function addBlock() {
            blocksNumber = Math.floor((blocklist.children.length) / 4)+1;
            let slct = document.createElement('select');
            slct.name = `block-${blocksNumber}-type`;
            slct.required = true;
            for (const block of allblocks) {
                let opt = document.createElement('option');
                let blname = block.name;
                opt.value = blname;
                opt.innerHTML = blname;
                slct.appendChild(opt);
            }
            blocklist.appendChild(slct);

            let rate = document.createElement('input');
            rate.type = "range";
            rate.name = `block-${blocksNumber}-rate`;
            rate.min = 0;
            rate.max = maxRateSlider.value;
            blocklist.appendChild(rate);

            let rateLabel = document.createElement('label');
            rateLabel.id = `${rate.name}-label`;
            rateLabel.innerHTML = maxRateSlider.value;
            rateLabel.className = "flex flex-row items-center";
            blocklist.appendChild(rateLabel);

            let delBtn = document.createElement('x-danger-button');
            delBtn.id = "btn-delblock";
            delBtn.className = "text-center text-2xl font-bolder inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150";
            delBtn.type = 'button';
            delBtn.innerHTML = '-';
            blocklist.appendChild(delBtn);
            updateOneSlider(rate);
        }
        function updateBlocks() {
            let sliders = document.querySelectorAll(`input[type='range'][name^='block']`);
            for (const sl of sliders) {
                sl.max = maxRateSlider.value;
            }
        }
        function updateOneSlider(slider){
            let label = blocklist.querySelector(`label[id^='${slider.name}']`)
            label.innerHTML = slider.value;
        }
        let allblocks = {!! json_encode($allblocks->toArray(), JSON_HEX_TAG) !!};
        let blocklist = document.querySelector('#blocklist');
        let addBlockBtn = document.querySelector('#btn-addblock');
        let maxRateSlider = document.querySelector('#blocks-maxrate');
        let blocksNumber = 0;

        addBlock();
        addBlockBtn.addEventListener('click', (e)=>{
            addBlock();
            updateBlocks();
        });
        blocklist.addEventListener('input', (e)=>{
            const targ = e.target;
            if (targ.type == 'range') {
                updateOneSlider(targ);
            }
        });
        maxRateSlider.addEventListener('change', (e)=>{
            updateBlocks();
        });
        /*
        <x-danger-button id="btn-delblock"
            class="text-center text-2xl font-bolder"
            type="button"
        >{{ __('-') }}</x-danger-button>
        */
    </script>
</x-app-layout>

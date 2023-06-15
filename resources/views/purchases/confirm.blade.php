<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('cards.index') }}"
            class="text-gray-500"
            >{{ __('Cards') }}</a>
            / {{ __('Confirm your purchase') }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="grid gap-4 md:grid-cols-5 grid-cols-2 mb-6">
            @foreach ($currentpurchase->items as $item)
                @php
                    $cd = $item->card;
                @endphp
                <div
                class="bg-white shadow-md sm:rounded-lg p-2 text-gray-900 flex flex-row justify-evenly items-center gap-3">
                    <a class="flex flex-col items-center w-[30%]"
                    href="{{ route('cards.show', $cd) }}">
                        <div class="flex flex-row items-center justify-center ">
                            @include('cards.partials.cardimg')
                        </div>
                    </a>
                    <form action="{{ route('purchases.items.remove', $item) }}" method="post"
                    class="flex flex-col self-center items-center justify-between">
                        @csrf
                        @method('DELETE')
                        <div class="text-center w-full">
                            <h4 class="text-xl font-bold">{{ $cd->name }}</h4>
                        </div>
                        <div class="flex flex-row gap-2 justify-between">
                            <h6 class="text-lg font-medium text-gray-700">{{ 'x'.$item->amount }}</h6>
                            <x-danger-button class="text-xl text-center">-</x-danger-button>
                        </div>
                        <h6 class="text-lg font-medium text-gray-700">{{ ($item->card->price * $item->amount) . '€' }}</h6>
                    </form>
                </div>
            @endforeach
        </div>
        <div class="w-7xl flex flex-row justify-around">
            <div class="w-full grid grid-flow-col grid-cols-5 grid-rows-3 text-gray-600 mb-3 items-center justify-center">
                <p class="text-xl">{{ __('Your current balance:') }}</p>
                <h3 class="font-bold text-5xl row-span-2">{{ $current_balance . ' €'}}</h3>

                <br>
                <p class="text-5xl row-span-2 text-center">-</p>

                <p class="text-xl text-gray-900">{{ __('Total price of purchase:') }}</p>
                <h3 class="font-black text-5xl row-span-2 text-gray-900">
                    <p class="underline">{{ $total_price . ' €'}}</p>
                    <x-input-error :messages="$errors->get('message')" class="mt-2 text-lg" />
                </h3>

                <br>
                <p class="text-5xl row-span-2 text-center">&equals;</p>

                <p class="text-xl">{{ __('Your final balance:') }}</p>
                <h3 class="font-bold text-5xl row-span-2 {{ ($final_balance < 0) ? "text-red-500" : '' }}">
                    {{ $final_balance . ' €'}}
                </h3>
            </div>
        </div>
        <form action="{{ route('purchases.confirm') }}" method="POST" class="w-full flex flex-row justify-center">
            @csrf
            <button
            class="w-1/6 items-center justify-center inline-flex
            px-4 py-2 bg-gray-800 border border-transparent
            rounded-md font-semibold text-xl text-white uppercase
            tracking-widest hover:bg-gray-700 focus:bg-gray-700
            active:bg-gray-900 focus:outline-none focus:ring-2
            focus:ring-indigo-500 focus:ring-offset-2
            transition ease-in-out duration-150">
                {{ __('Confirm purchase') }}
            </button>
        </form>
    </div>
</x-app-layout>

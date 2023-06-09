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
        <form action="" method="POST" class="w-full flex flex-col justify-center items-center mb-3">
            <p class="text-xl">{{ __('Total price:') }}</p>
            <h3 class="font-black text-5xl">{{ $total_price . ' €'}}</h3>
        </form>
        <form action="" method="POST" class="w-full flex flex-row justify-center">
            @csrf
            <a href="{{ route('purchases.confirm.show') }}"
            class="w-1/6 items-center justify-center inline-flex
            px-4 py-2 bg-gray-800 border border-transparent
            rounded-md font-semibold text-xl text-white uppercase
            tracking-widest hover:bg-gray-700 focus:bg-gray-700
            active:bg-gray-900 focus:outline-none focus:ring-2
            focus:ring-indigo-500 focus:ring-offset-2
            transition ease-in-out duration-150">
                {{ __('Purchase') }}
            </a>
        </form>
    </div>
</x-app-layout>

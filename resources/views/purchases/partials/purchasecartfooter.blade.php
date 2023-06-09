@auth
    @php
    $currentpurchase = Auth::user()->current_purchases->first();
    @endphp
    @isset($currentpurchase)
    <footer class="bottom-0 fixed inset-x-0 border-t-2 bg-white max-h-[20vh] flex flex-row overflow-scroll justify-left">
        @foreach ($currentpurchase->items as $item)
            @php
                $cd = $item->card;
            @endphp
            <div
            class="w-[12vw] bg-white shadow-md sm:rounded-lg p-2 text-gray-900 flex flex-row justify-center items-center gap-1">
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
                </form>
            </div>
        @endforeach
    </footer>
    @endisset
@endauth

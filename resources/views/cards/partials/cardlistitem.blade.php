<div
class="bg-white overflow-hidden shadow-md sm:rounded-lg p-3 text-gray-900 flex flex-row w-full">
    <div class="sm:max-w-3/6 w-full flex flex-col">
        <a class="flex flex-col justify-between gap-3"
        href="{{ route('cards.show', $cd) }}">
            <div class="flex flex-row items-center justify-center">
                @include('cards.partials.cardimg')
            </div>
            <div class="text-center w-full">
                <h4 class="text-xl font-bold">{{ $cd->name }}</h4>
                <!--<p class="text-sm text-gray-700">
                    {!! nl2br(e($cd->description)) !!}
                </p>-->
            </div>
        </a>
        <form action="{{ route('purchases.cards.add', $cd) }}" method="post"
        class="flex flex-row items-center justify-between">
            @csrf
            <div class="flex flex-col w-4/6">
                <label for="amount">{{ __('Quantity:') }}</label>
                <input type="number" name="amount" value=1 min="1" max="{{ $cd->stock }}" class="">
            </div>
            <x-primary-button class="text-2xl self-end">+</x-primary-button>
        </form>
        <p class="text-gray-500 text-sm text-right">{{ __('Left in stock: ') . $cd->stock }}</p>
    </div>
</div>

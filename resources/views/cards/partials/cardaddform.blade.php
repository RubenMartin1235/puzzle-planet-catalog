@auth
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
    @php
        $duhc = $cd->collected_by_users->where('user_id', Auth::user()->id)->first();
        $amount_collected = isset($duhc) ? $duhc->pivot->amount : 0;
    @endphp
    <p class="text-{{ $amount_collected > 0 ? 'green' : 'gray'}}-800 text-sm text-right">
        {{
            ($amount_collected > 0) ?
            __('You currently have: ') . $amount_collected :
            __("You don't have this card yet.")
        }}
    </p>
@endauth

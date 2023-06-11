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

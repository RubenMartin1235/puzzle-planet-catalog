<form action="{{ route('cards.restock', $cd) }}" method="post"
class="flex flex-row items-center justify-between">
    @csrf
    @method('PATCH')
    @include('cards.partials.stockfield')
    <x-primary-button class="text-2xl self-end">{{ __('Edit stock') }}</x-primary-button>
</form>

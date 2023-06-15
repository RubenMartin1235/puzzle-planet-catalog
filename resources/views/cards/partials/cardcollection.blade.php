<div class="grid gap-4 md:grid-cols-5 grid-cols-2 mb-[20vh]">
    @if ($cards->first())
        @foreach ($cards as $cd)
            @include('cards.partials.cardcollectionitem')
        @endforeach
    @else
        <p class="text-lg">{{ __('There are no cards here!') }}</p>
    @endif
</div>
{{ $cards->links() }}

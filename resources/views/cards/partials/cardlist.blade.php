<div class="grid gap-4 md:grid-cols-5 grid-cols-2">
    @if ($cards->first())
        @foreach ($cards as $cd)
            @include('cards.partials.cardlistitem')
        @endforeach
    @else
        <p class="text-lg">{{ __('There are no cards here!') }}</p>
    @endif
</div>
{{ $cards->links() }}

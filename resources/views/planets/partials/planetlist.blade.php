<div class="grid gap-4 md:grid-cols-3 grid-cols-2">
    @if ($planets->first())
        @foreach ($planets as $pl)
            @include('planets.partials.planetlistitem')
        @endforeach
    @else
        <p class="text-lg">{{ __('There are no planets here!') }}</p>
    @endif
</div>
{{ $planets->links() }}

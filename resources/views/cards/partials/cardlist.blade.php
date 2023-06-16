<div class="grid gap-4 md:grid-cols-5 grid-cols-2 mb-[20vh]">
    @auth
        @if (Auth::user()->hasAnyRole(['admin','loader']))
            <a href="{{ route('cards.create') }}" class="w-full text-center flex flex-row">
                <x-primary-button class="w-full !text-9xl flex flex-row justify-center">
                    <p class="text-center">+</p>
                </x-primary-button>
            </a>
        @endif
    @endauth
    @if ($cards->first())
        @foreach ($cards as $cd)
            @include('cards.partials.cardlistitem')
        @endforeach
    @else
        <p class="text-lg">{{ __('There are no cards here!') }}</p>
    @endif
</div>
{{ $cards->links() }}

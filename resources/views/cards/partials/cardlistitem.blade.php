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
                <p class="text-right text-3xl font-bold">{{ $cd->price . ' €' }}</p>
            </div>
        </a>
        @include('cards.partials.cardaddform')
        @auth
            @if(Auth::user()->hasAnyRole(['loader','admin']))
                @include('cards.partials.actionslist')
            @endif
        @endauth
    </div>
</div>

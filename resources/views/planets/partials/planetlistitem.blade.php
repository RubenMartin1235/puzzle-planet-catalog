<div
class="bg-white overflow-hidden shadow-md sm:rounded-lg p-3 text-gray-900 flex flex-row w-full">
    <div class="w-full">
        <a class="flex sm:flex-row flex-col justify-between gap-3"
        href="{{ route('planets.show', $pl) }}">
            <div class="sm:w-1/6 flex flex-row items-center justify-center md:justify-left">
                @include('planets.partials.planetimg')
            </div>
            <div class="text-center sm:w-5/6">
                <h4 class="text-xl font-bold">{{ $pl->name }}</h4>
                <p class="text-sm text-gray-700">{!! nl2br(e($pl->bio)) !!}</p>
            </div>
        </a>
        <div class="w-full flex flex-row justify-between gap-3">
            @if(Auth::user() == $pl->user)
                @include('planets.partials.actionslist')
            @endif
            <div class="grow text-xs text-gray-500 self-end text-right">
                @include('planets.partials.authortext')
            </div>
        </div>
    </div>
</div>

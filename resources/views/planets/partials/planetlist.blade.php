<div class="grid gap-4 md:grid-cols-3 grid-cols-2">
    @foreach ($planets as $pl)
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
                        <p class="text-sm text-gray-700">{{ $pl->bio }}</p>
                    </div>
                </a>
                <div class="w-full flex flex-row justify-between gap-3">
                    @if(Auth::user() == $pl->user)
                        @include('planets.partials.actionslist')
                    @endif
                    <div class="grow text-xs text-gray-500 self-end text-right">
                        <span>made by </span>
                        <a href="{{ route('profile.show', $pl->user) }}" class="text-gray-700 underline">{{ $pl->user->name }}</a>
                        <span> on {{ Carbon\Carbon::parse($pl->created_at)->format('Y/m/d') }}</span>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
{{ $planets->links() }}

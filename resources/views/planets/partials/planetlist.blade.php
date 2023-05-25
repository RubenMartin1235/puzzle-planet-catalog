<div class="grid gap-4 md:grid-cols-3 grid-cols-2">
    @foreach ($planets as $pl)
        <div
        class="bg-white overflow-hidden shadow-md sm:rounded-lg p-3 text-gray-900 flex flex-row">
            <div class="">
                <a class="flex sm:flex-row flex-col justify-between gap-3"
                href="{{ route('planets.show', $pl) }}">
                    <div class="md:w-1/6 flex flex-row items-center justify-center md:justify-left">
                        @include('planets.partials.planetimg')
                    </div>
                    <div class="text-center sm:w-5/6">
                        <h4 class="text-xl font-bold">{{ $pl->name }}</h4>
                        <p class="text-sm text-gray-700">{{ $pl->bio }}</p>
                    </div>
                </a>
                <div class="flex flex-row justify-between">
                    @if(Auth::user() == $pl->user)
                        <div class="flex flex-row justify-left gap-4">
                            <x-primary-button class="mt-4">{{ __('Edit') }}</x-primary-button>
                            <x-primary-button class="mt-4 bg-danger">{{ __('Delete') }}</x-primary-button>
                        </div>
                    @endif
                    <div class="w-full text-xs text-gray-500 self-end text-right">
                        <span>made by <a href="{{ route('profile.show', $pl->user) }}" class="text-gray-700 underline">{{ $pl->user->name }}</a> on {{ Carbon\Carbon::parse($pl->created_at)->format('Y/m/d') }}</span>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
{{ $planets->links() }}

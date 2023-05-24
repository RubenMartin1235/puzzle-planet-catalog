<div class="grid gap-4 grid-cols-3">
    @foreach ($planets as $pl)
        <a
        href="{{ route('planets.show', $pl) }}"
        class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-3 text-gray-900 flex flex-col">
            <h4 class="text-lg font-bold text-center">{{ $pl->name }}</h4>
            <p class="text-sm text-gray-700">{{ $pl->bio }}</p>
        </a>
    @endforeach
</div>
{{ $planets->links() }}

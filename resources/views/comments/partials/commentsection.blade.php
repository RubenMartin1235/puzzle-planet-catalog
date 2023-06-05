<div class="py-3">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex flex-col">
            <div
            class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6
            text-gray-900 flex flex-col gap-3"
            >
            <div class="flex flex-row gap-3">
                <h4 class="text-3xl font-bold text-left">{{ __('Comments') }}</h4>
                <a href="{{ route('planets.comments.create', $pl) }}">
                    <x-primary-button>{{ __('Comment') }}</x-primary-button>
                </a>
            </div>
                @include('comments.partials.commentlist')
            </div>
        </div>
    </div>
</div>

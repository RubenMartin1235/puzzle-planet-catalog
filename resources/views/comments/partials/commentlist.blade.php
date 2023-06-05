<div class="flex flex-col sm:gap-2 py-3">
    @if ($comments->first())
        @foreach ($comments as $cm)
            <div class="flex flex-col p-3 shadow-md">
                <div class="flex flex-row gap-3 justify-between">
                    <div class="flex flex-row gap-3">
                        <a href="{{ route('profile.show', $cm->user) }}" class="font-bold text-md">
                            {{ $cm->user->name }}
                        </a>
                        <span class="text-gray-500">
                            <p>
                                {{
                                    __(' on ')
                                    . Carbon\Carbon::parse($cm->created_at)->format('Y/m/d')
                                    . ($cm->created_at <> $cm->updated_at ? __(' (edited)') : '')
                                }}
                            </p>
                        </span>
                    </div>
                    <div class="flex flex-row justify-left gap-2">
                        @if (Auth::user()->id == $cm->user->id)
                            <a href="{{ route('comments.edit', $cm) }}">
                                <x-primary-button>{{ __('Edit') }}</x-primary-button>
                            </a>
                            <x-danger-button
                            class="commentDelBtn"
                            data-modal-show="del-cm-popup-modal"
                            data-comment="{{ $cm->id }}">{{ __('Delete') }}</x-danger-button>
                        @endif
                    </div>
                </div>
                <p class="text-md">
                    {!! nl2br(e($cm->message)) !!}
                </p>
            </div>
        @endforeach
    @else
        <p class="text-lg">{{ __('There are no comments here!') }}</p>
    @endif
    {{ $comments->links() }}
    @include('comments.partials.deletemodal')
</div>

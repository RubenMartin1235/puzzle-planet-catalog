<div class="flex flex-col sm:gap-2 py-3">
    @if ($comments->first())
        @foreach ($comments as $cm)
            <div class="flex flex-col p-3 shadow-md">
                @if (!Str::endsWith(Route::currentRouteName(), 'show') )
                    @php($commentable_table = $cm->commentable->getTable())
                    <p class="text-gray-600 pb-2">
                        {{ __('(Commented on ') . Str::singular($commentable_table) . ' '}}
                        <a href="{{ route($commentable_table . '.show', $cm->commentable) }}"
                            class="text-gray-900 underline">{{ $cm->commentable->name }}</a>{{ ')' }}
                    </p>

                @endif
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
                        @auth
                            @if (Auth::user()->id == $cm->user->id || Auth::user()->hasAnyRole(['admin']))
                                <a href="{{ route('comments.edit', $cm) }}">
                                    <x-primary-button>{{ __('Edit') }}</x-primary-button>
                                </a>
                                <x-danger-button
                                class="commentDelBtn"
                                data-modal-show="del-cm-popup-modal"
                                data-comment="{{ $cm->id }}">{{ __('Delete') }}</x-danger-button>
                            @endif
                        @endauth
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

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('cards.index') }}"
            class="text-gray-500"
            >{{ __('Cards') }}</a>
            / {{ $cd->name }}
        </h2>
    </x-slot>

    <div class="py-12 mb-[20vh]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col">
                <div
                class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-3
                text-gray-900 flex flex-col gap-3"
                >
                    <h4 class="text-3xl font-bold text-center">{{ $cd->name }}</h4>
                    <div class="flex md:flex-row flex-col gap-6 p-6">
                        <div class="md:w-2/6 w-full flex flex-col">
                            @auth
                                @if (Auth::user()->hasAnyRole(['loader','admin']))
                                    <div class="mx-auto">
                                        @include('cards.partials.actionslist')
                                    </div>
                                @endif
                            @endauth
                            <div class="w-full">
                                @include('cards.partials.cardimg')
                            </div>
                        </div>
                        <div class="grow flex flex-col gap-3">
                            <div class="flex flex-flow justify-between gap-6">
                                <p class="text-xl text-left px-3 py-3 text-gray-900 border-dotted border-2 border-gray-300">
                                    {!! nl2br(e($cd->description)) !!}
                                </p>
                                <p class="text-4xl font-black underline">
                                    {{ $cd->price . __(' €') }}
                                </p>
                            </div>
                            <div class="px-3">
                                @include('cards.partials.cardaddform')
                            </div>
                            @auth
                                @if (Auth::user()->hasAnyRole(['loader','admin']))
                                    <div class="justify-self-end px-3">
                                        @include('cards.partials.restockform')
                                    </div>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('comments.partials.commentsection')
    </div>
    @include('planets.partials.deletemodal')
    @include('purchases.partials.purchasecartfooter')
    @include('cards.partials.delmodal')
</x-app-layout>

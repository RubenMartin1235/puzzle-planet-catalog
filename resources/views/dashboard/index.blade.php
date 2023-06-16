<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    @include('dashboard.partials.navbar')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 w-full grid md:grid-cols-2 grid-cols-1">
                    <div class="text-gray-700">
                        <span>{{ __("Welcome, ") . (isset($role) ? $role->name : __('user')) . ' ' }}</span>
                        <span class="text-gray-900 font-bold">{{ Auth::user()->name }}</span><span>{{ "!" }}</span>
                    </div>
                    <div class="bg-white overflow-hidden shadow-md sm:rounded-lg w-full grid grid-cols-3 grid-rows-1 items-center p-3">
                        <p class="">{{ __('Your balance:')}}</p>
                        <p class="text-gray-900 text-lg font-medium">{{ $balance . __(' €') }}</p>
                        <a href="{{ route('dashboard.topup') }}" class="justify-self-center"><x-secondary-button>{{ __('Top up') }}</x-secondary-button></a>
                    </div>
                </div>


                <div class="p-6 text-gray-900">
                    <h4 class="text-2xl font-bold py-3">{{ __("Your latest planets") }}</h4>
                    @include('planets.partials.planetlist')
                </div>
                <div class="p-6 text-gray-900">
                    <h4 class="text-2xl font-bold py-3">{{ __("Your latest comments") }}</h4>
                    @include('comments.partials.commentlist')
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    @include('dashboard.partials.navbar')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
                <div class="max-w-lg mx-auto grid grid-cols-2 grid-rows-1 items-center p-3">
                    <p class="text-xl">{{ __('Your current balance:')}}</p>
                    <p class="text-gray-900 text-4xl font-medium text-right">{{ $balance . __(' €') }}</p>
                </div>
                <form method="POST" action="{{ route('dashboard.topup.action') }}" class="max-w-3xl mx-auto bg-white overflow-hidden grid grid-cols-2 gap-2 items-center">
                    @csrf
                    @method('PUT')
                    <label for="topup">{{ __('Money to top up your account with?') }}</label>
                    <input type="number" name="topup" step="0.01" min="0" max="1000">
                    <label for="topup">{{ __('Credit card code:') }}</label>
                    <input type="text" name="ccc">
                    <div class="col-span-2 w-full py-3 mx-auto flex flex-row justify-around">
                        <x-primary-button>{{ __('Accept Transaction') }}</x-primary-button>
                        <a href="{{ route('dashboard') }}">
                            <x-secondary-button>{{ __('Cancel') }}</x-secondary-button>
                        </a>
                    </div>
                    <x-input-error :messages="$errors->get('message')" class="mt-2" />
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cards') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('purchase_result'))
                <p class="alert alert-success">
                    {{ session('purchase_result') }}
                </p>
            @endif
            @include('cards.partials.cardlist')
        </div>
    </div>
    @include('purchases.partials.purchasecartfooter')
</x-app-layout>

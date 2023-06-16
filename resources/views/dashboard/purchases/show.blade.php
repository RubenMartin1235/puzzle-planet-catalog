<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('dashboard') }}"
            class="text-gray-500"
            >{{ __('Dashboard') }}</a>
            / <a href="{{ route('dashboard.purchases') }}"
            class="text-gray-500"
            >{{ __('Purchases') }}</a>
            / {{ __('Purchase ' . $purchase->id) }}
        </h2>
    </x-slot>
    @include('dashboard.partials.navbar')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <table class="table-auto bg-white overflow-hidden shadow-md sm:rounded-lg text-gray-900 w-full p-6 mb-6">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>user</th>
                        <th>status</th>
                        <th>price</th>
                        <th>initDate</th>
                        <th>paymentDate</th>
                        <th>ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border-2 border-solid border-gray-200">{{ $purchase->id }}</td>
                        <td class="border-2 border-solid border-gray-200"><a href="{{ route('profile.show', $purchase->user) }}">{{ $purchase->user->name }}</a></td>
                        <td class="border-2 border-solid border-gray-200 {{ $purchase->status == 'finished' ? 'text-green-600' : '' }}">{{ $purchase->status }}</td>
                        <td class="{{ $purchase->final_price ? 'text-right' : 'text-center text-gray-400' }} border-2 border-solid border-gray-200">
                            {{ $purchase->final_price ?? '-'}}
                        </td>
                        <td class="border-2 border-solid border-gray-200">{{ Carbon\Carbon::parse($purchase->created_at)->format('Y/m/d') }}</td>
                        <td class="border-2 border-solid border-gray-200">{{ Carbon\Carbon::parse($purchase->updated_at)->format('Y/m/d') }}</td>
                        <td class="gap-3 border-2 border-solid border-gray-200">
                            <a href="">
                                <x-primary-button>{{ __('VIEW ITEMS') }}</x-primary-button>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
            <h2>{{ __('Purchase Items') }}</h2>
            <table class="table-auto bg-white overflow-hidden shadow-md sm:rounded-lg text-gray-900 w-full p-6">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>card</th>
                        <th>amount</th>
                        <th>price per unit</th>
                        <th>total item price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td class="border-2 border-solid border-gray-200">{{ $item->id }}</td>
                            <td class="border-2 border-solid border-gray-200"><a href="{{ route('cards.show', $item->card) }}">
                                {{ $item->card->name . ' (id = ' . $item->card->id . ')' }}
                            </a></td>
                            <td class="border-2 border-solid border-gray-200">{{ $item->amount }}</td>
                            <td class="border-2 border-solid border-gray-200 text-right">{{ $item->card->price }}</td>
                            <td class="border-2 border-solid border-gray-200 text-right">{{ $item->card->price * $item->amount }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>

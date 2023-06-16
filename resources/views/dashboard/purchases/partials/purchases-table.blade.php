<table class="table-auto bg-white overflow-hidden shadow-md sm:rounded-lg text-gray-900 w-full p-6">
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
        @foreach ($purchases as $purchase)
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
                    <a href="{{ route('dashboard.purchases.show', $purchase) }}">
                        <x-primary-button>{{ __('VIEW ITEMS') }}</x-primary-button>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

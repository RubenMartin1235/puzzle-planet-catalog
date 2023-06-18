<table class="table-auto bg-white overflow-hidden shadow-md sm:rounded-lg text-gray-900 w-full p-6">
    <thead>
        <tr>
            <th>ID</th>
            <th>name</th>
            <th>image</th>
            <th>price</th>
            <th>stock</th>
            <th>description</th>
            <th>created_at</th>
            <th>updated_at</th>
            <th>ACTIONS</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($cards as $cd)
            <tr>
                <td class="border-2 border-solid border-gray-200">{{ $cd->id }}</td>
                <td class="border-2 border-solid border-gray-200"><a href="{{ route('cards.show', $cd) }}">{{ $cd->name }}</a></td>
                <td class="{{ $cd->image ? 'text-left underline text-blue-600' : 'text-center text-gray-400' }} border-2 border-solid border-gray-200">
                    <a href="{{ isset($cd->image) ? (asset('storage/'.$cd->image)) : '' }}">{{ $cd->image ?? '-' }}</a>
                </td>
                <td class="border-2 border-solid border-gray-200">{{ $cd->price }}</td>
                <td class="border-2 border-solid border-gray-200">{{ $cd->stock }}</td>
                <td class="border-2 border-solid border-gray-200 ellipsis">
                    {{ Str::words($cd->description, 8, '...') }}
                </td>
                <td class="border-2 border-solid border-gray-200">{{ Carbon\Carbon::parse($cd->created_at)->format('Y/m/d') }}</td>
                <td class="border-2 border-solid border-gray-200">{{ Carbon\Carbon::parse($cd->updated_at)->format('Y/m/d') }}</td>
                <td class="gap-3 border-2 border-solid border-gray-200 max-w-1/6">
                    <div class="flex flex-row justify-center gap-3">
                        <x-danger-button
                            x-data @click="document.querySelector('input#card_id').value = {{ $cd->id }}"
                            x-on:click.prevent="$dispatch('open-modal', 'confirm-card-deletion')"
                        >{{ __('DELETE CARD') }}</x-danger-button>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@include('dashboard.cards.partials.delmodal_card')

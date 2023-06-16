<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('dashboard') }}"
            class="text-gray-500"
            >{{ __('Dashboard') }}</a>
            / {{ __('Users') }}
        </h2>
    </x-slot>
    @include('dashboard.partials.navbar')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <table class="table-auto bg-white overflow-hidden shadow-md sm:rounded-lg text-gray-900 w-full p-6">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>name</th>
                        <th>email</th>
                        <th>roles</th>
                        <th>balance</th>
                        <th>ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td><a href="{{ route('profile.show', $user) }}">{{ $user->name }}</a></td>
                            <td>{{ $user->email }}</td>
                            <td>{{implode(',', $user->roles()->pluck('name')->toArray())}}</td>
                            <td class="text-right">{{ $user->balance }}</td>
                            <td class="w-full flex flex-row justify-center gap-3">
                                <a href="{{ route('dashboard.users.edit', $user) }}">
                                    <x-primary-button>{{ __('EDIT') }}</x-primary-button>
                                </a>
                                <a href="{{ route('dashboard.users.purchases', $user) }}">
                                    <x-primary-button>{{ __('VIEW PURCHASES') }}</x-primary-button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $users->links() }}
        </div>
    </div>
</x-app-layout>

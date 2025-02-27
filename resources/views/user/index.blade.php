@extends('layouts.app')

@section('header')
    <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
        {{ __('User Analysis') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Tabel Statistik User --}}
                    <div class="mb-6">
                        <h3 class="mb-3 text-lg font-semibold text-gray-800 dark:text-gray-200">User Statistics</h3>
                        <table class="w-full text-sm text-center text-gray-500 border border-gray-300 dark:text-gray-400 dark:border-gray-600">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th class="px-6 py-3 border">Total Users</th>
                                    <th class="px-6 py-3 border">Total Admins</th>
                                    <th class="px-6 py-3 border">Total Regular Users</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-white dark:bg-gray-800">
                                    <td class="px-6 py-4 font-medium text-gray-900 border dark:text-white">{{ $totalUsers }}</td>
                                    <td class="px-6 py-4 font-medium text-gray-900 border dark:text-white">{{ $totalAdmins }}</td>
                                    <td class="px-6 py-4 font-medium text-gray-900 border dark:text-white">{{ $totalReguler }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    {{-- Form Pencarian --}}
                    <div class="mb-6">
                        <form method="GET" action="{{ route('user.index') }}" class="flex items-center space-x-2">
                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Search users..."
                                class="w-full px-4 py-2 border rounded-lg dark:bg-gray-700 dark:text-white focus:ring focus:ring-blue-300"
                            >
                            <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                                Search
                            </button>
                        </form>
                    </div>

                    {{-- Tabel Detail User dan Todos --}}
                    <div class="relative overflow-x-auto">
                        <h3 class="mb-3 text-lg font-semibold text-gray-800 dark:text-gray-200">User & Todo Details</h3>
                        <table class="w-full text-sm text-left text-gray-500 border border-gray-300 dark:text-gray-400 dark:border-gray-600">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th class="px-6 py-3 border">ID</th>
                                    <th class="px-6 py-3 border">Name</th>
                                    <th class="hidden px-6 py-3 border md:table-cell">Email</th>
                                    <th class="px-6 py-3 border">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr class="{{ $loop->odd ? 'bg-white dark:bg-gray-800' : 'bg-gray-50 dark:bg-gray-700' }}">
                                        <td class="px-6 py-4 font-medium text-gray-900 border dark:text-white">{{ $user->id }}</td>
                                        <td class="px-6 py-4 font-medium text-gray-900 border dark:text-white">{{ $user->name }}</td>
                                        <td class="hidden px-6 py-4 border md:table-cell">{{ $user->email }}</td>
                                        <td class="px-6 py-4 text-center border">
                                            <div class="flex items-center space-x-2">

                                                {{-- Button Make/Remove Admin --}}
                                                @if ($user->is_admin)
                                                    <form action="{{ route('user.removeadmin', $user) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit"
                                                            class="px-4 py-2 text-white bg-red-600 rounded-lg hover:bg-red-700">
                                                            Remove Admin
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('user.makeadmin', $user) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit"
                                                            class="px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                                                            Make Admin
                                                        </button>
                                                    </form>
                                                @endif

                                                {{-- Button Delete User --}}
                                                <form action="{{ route('user.destroy', $user) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="px-4 py-2 text-white bg-red-600 rounded-lg hover:bg-red-700">
                                                        Delete
                                                    </button>
                                                </form>

                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="bg-white dark:bg-gray-800">
                                        <td colspan="7" class="px-6 py-4 font-medium text-center text-gray-900 border dark:text-white">
                                            No users found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    @if ($users->hasPages())
                        <div class="p-6">
                            {{ $users->links() }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection

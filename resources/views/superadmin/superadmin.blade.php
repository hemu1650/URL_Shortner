<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            SuperAdmin Dashboard
        </h2>
    </x-slot>

    <div class="py-6 px-6 mx-auto max-w-7xl">
        {{-- Clients Overview --}}
        <div class="mb-8 bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-bold text-gray-700 mb-4 flex justify-between items-center">
            Clients
            <a href="{{ route('superadmin.invite') }}">
                <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Invite</button>
            </a>
        </h3>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left border border-gray-200">
                <thead class="bg-gray-100 text-xs text-gray-600 uppercase tracking-wider">
                    <tr>
                        <th class="px-4 py-2 border">Name</th>
                        <th class="px-4 py-2 border">Email</th>
                        <th class="px-4 py-2 border text-center">Members</th>
                        <th class="px-4 py-2 border text-center">Total URLs</th>
                        <th class="px-4 py-2 border text-center">Total Hits</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @forelse ($clientsPaginated as $client)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-2 border">{{ $client->company_name }}</td>
                            <td class="px-4 py-2 border">{{ $client->email }}</td>
                            <td class="px-4 py-2 border text-center">{{ $client->members_count }}</td>
                            <td class="px-4 py-2 border text-center">{{ $client->total_urls }}</td>
                            <td class="px-4 py-2 border text-center">{{ $client->total_hits }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-gray-500 px-4 py-4">No clients found.</td>
                        </tr>
                    @endforelse
                </tbody>

                {{-- @if ($clientsPaginated->count())
                    <tfoot>
                        <tr class="bg-gray-50 font-semibold">
                            <td class="px-4 py-2 border text-right" colspan="2">Total</td>
                            <td class="px-4 py-2 border text-center">
                                {{ $clientsPaginated->sum('members_count') }}
                            </td>
                            <td class="px-4 py-2 border text-center">
                                {{ $clientsPaginated->sum('total_urls') }}
                            </td>
                            <td class="px-4 py-2 border text-center">
                                {{ $clientsPaginated->sum('total_hits') }}
                            </td>
                        </tr>
                    </tfoot>
                @endif --}}
            </table>
        </div>

        {{-- Pagination Info --}}
        @if ($clientsPaginated instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="mt-4 flex justify-between items-center text-sm text-gray-600">
                <div>
                    Showing {{ $clientsPaginated->firstItem() }} to {{ $clientsPaginated->lastItem() }} of {{ $clientsPaginated->total() }} results
                </div>
                <div>
                    {{-- {{ $clientsPaginated->links() }} --}}
                </div>
            </div>
        @endif

        {{-- View All Clients Button --}}
        <div class="mt-4 text-right">
            <a href="{{ route('superadmin.clients') }}">
                <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 border border-gray-300 px-4 py-2 rounded">
                    View All Clients
                </button>
            </a>
        </div>
    </div>


        {{-- Latest Short URLs --}}
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-bold text-gray-700 mb-4">Latest Short URLs

                <div class="mb-4 flex justify-end items-center space-x-2">
                    <form action="{{ route('superadmin.export.urls') }}" method="GET" class="flex items-center space-x-2">
                        <select name="range" required class="border rounded px-3 py-2 text-sm">
                            <option value="">-- Select Range --</option>
                            <option value="today">Today</option>
                            <option value="last_week">Last Week</option>
                            <option value="last_month">Last Month</option>
                            <option value="this_month">This Month</option>
                        </select>
                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                            Export CSV
                        </button>
                    </form>
                </div>

            </h3>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left border border-gray-200">
                    <thead class="bg-gray-100 text-xs text-gray-600 uppercase tracking-wider">
                        <tr>
                            <th class="px-4 py-2 border">Short URL</th>
                            <th class="px-4 py-2 border">Long URL</th>
                            <th class="px-4 py-2 border">Hits</th>
                            <th class="px-4 py-2 border">Name</th>
                            <th class="px-4 py-2 border">Created By</th>
                            {{-- <th class="px-4 py-2 border">Role</th> --}}
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @forelse ($urls as $url)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-2 border text-blue-600">
                                    <a href="{{ url('/s/' . $url->short_code) }}" target="_blank" class="hover:underline">
                                        {{ url('/' . $url->short_code) }}
                                    </a>
                                </td>
                                <td class="px-4 py-2 border truncate max-w-xs">{{ $url->original_url }}</td>
                                <td class="px-4 py-2 border"></td>
                                <td class="px-4 py-2 border">{{ $url->user->name ?? 'N/A' }}</td>
                                <td class="px-4 py-2 border">{{ $url->created_at }}</td>
                                {{-- <td class="px-4 py-2 border capitalize">{{ $url->user->role ?? 'N/A' }}</td> --}}
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-gray-500 px-4 py-4">No URLs found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination Info + Links --}}
                @if ($urls->count())
                <div class="flex items-center justify-between mt-4 text-sm text-gray-600">
                    <div>
                        Showing {{ $urls->firstItem() }} to {{ $urls->lastItem() }} of {{ $urls->total() }} results
                    </div>
                    <div>
                        {{-- {{ $urls->links() }} --}}
                        <div class="mt-4 text-right">
                        <a href="{{ route('superadmin.urls.index') }}">
                            <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 border border-gray-300 px-4 py-2 rounded">
                                View All
                            </button>
                        </a>
                    </div>
                    </div>
                </div>
                @endif
            </div>
        </div>


    </div>
</x-app-layout>

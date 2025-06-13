<x-app-layout>
    <div class="py-6 px-6 mx-auto max-w-7xl">
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Admin Dashboard
        </h2>
    </x-slot>

        {{-- Members Overview --}}
        <div class="mb-8 bg-white shadow rounded-lg p-6">
            
            <h3 class="text-lg font-bold text-gray-700 mb-4 flex justify-between items-center">
                Team Members
                <a href="{{ route('admin.invite') }}">
                    <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Invite</button>
                </a>
            </h3>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left border border-gray-200">
                    <thead class="bg-gray-100 text-xs text-gray-600 uppercase tracking-wider">
                        <tr>
                            <th class="px-4 py-2 border">Name</th>
                            <th class="px-4 py-2 border">Email</th>
                            <th class="px-4 py-2 border text-center">Role</th>
                            <th class="px-4 py-2 border text-center">Total URLs</th>
                            <th class="px-4 py-2 border text-center">Total Hits</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        {{-- @foreach ($clients as $client)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-2 border">{{ $client->company_name }}</td>
                                <td class="px-4 py-2 border">{{ $client->email }}</td>
                                <td class="px-4 py-2 border text-center">{{ $client->members_count }}</td>
                                <td class="px-4 py-2 border text-center">{{ $client->total_urls }}</td>
                                <td class="px-4 py-2 border text-center">{{ $client->total_hits }}</td>
                            </tr>
                        @endforeach --}}
                        @foreach ($members as $member)
                            <tr>
                                <td class="px-4 py-2 border">{{ $member->name }}</td>
                                <td class="px-4 py-2 border">{{ $member->email }}</td>
                                <td class="px-4 py-2 border">{{ $member->role }}</td>
                                <td class="px-4 py-2 border text-center">{{ $member->shortUrls->count() }}</td>
                                <td class="px-4 py-2 border text-center">{{ $member->shortUrls->sum('hits') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination Info --}}
            @if ($members instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="mt-4 flex justify-between items-center text-sm text-gray-600">
                    <div>
                        Showing {{ $members->firstItem() }} to {{ $members->lastItem() }} of {{ $members->total() }} results
                    </div>
                    <div>
                        {{-- {{ $members->links() }} --}}

                        {{-- View All Clients Button --}}
                        <div class="mt-4 text-right">
                            <a href="{{ route('admin.members.index') }}">
                                <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 border border-gray-300 px-4 py-2 rounded">
                                    View All
                                </button>
                            </a>
                        </div>

                    </div>
                </div>
            @endif

            

        </div>

        {{-- Latest Short URLs --}}
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-bold text-gray-700 mb-4 flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    Latest Short URLs
                    @unless(Auth::user()->role === 'superadmin')
                        <a href="{{ route('urls.create') }}">
                            <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Generate</button>
                        </a>
                    @endunless
                </div>

                <div class="flex items-center space-x-4">
                    <form action="{{ route('admin.export.urls') }}" method="GET" class="flex items-center space-x-2">
                        <select name="range" required class="border rounded px-3 py-2 text-sm">
                            <option value="">Select Range</option>
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

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left border border-gray-200">
                    <thead class="bg-gray-100 text-xs text-gray-600 uppercase tracking-wider">
                        <tr>
                            <th class="px-4 py-2 border">Short URL</th>
                            <th class="px-4 py-2 border">Original URL</th>
                            <th class="px-4 py-2 border">Created By</th>
                            <th class="px-4 py-2 border">Role</th>
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
                                <td class="px-4 py-2 border">{{ $url->user->name ?? 'N/A' }}</td>
                                <td class="px-4 py-2 border capitalize">{{ $url->user->role ?? 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-gray-500 px-4 py-4">No URLs found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-4 flex justify-between items-center text-sm text-gray-600">
                <div>
                    Showing {{ $urls->firstItem() }} to {{ $urls->lastItem() }} of {{ $urls->total() }} results
                </div>
                <div>
                    {{-- {{ $urls->links() }} --}}
                    <div class="mt-4 text-right">
                        <a href="{{ route('admin.urls.index') }}">
                            <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 border border-gray-300 px-4 py-2 rounded">
                                View All
                            </button>
                        </a>
                    </div>
                </div>
            </div>


        </div>

    </div>
</x-app-layout>

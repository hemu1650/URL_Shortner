<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">All Short URLs</h2>
    </x-slot> --}}

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">

                <div class="mb-4 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-700">Latest Short URLs</h3>
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

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left border border-gray-200">
                        <thead class="bg-gray-100 text-xs text-gray-600 uppercase tracking-wider">
                            <tr>
                                <th class="px-4 py-2 border">Short URL</th>
                                <th class="px-4 py-2 border">Long URL</th>
                                <th class="px-4 py-2 border">Hits</th>
                                <th class="px-4 py-2 border">Name</th>
                                <th class="px-4 py-2 border">Created At</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @forelse ($urls as $url)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 border text-blue-600">
                                        <a href="{{ url('/s/' . $url->short_code) }}" target="_blank" class="hover:underline">
                                            {{ url('/' . $url->short_code) }}
                                        </a>
                                    </td>
                                    <td class="px-4 py-2 border truncate max-w-xs">{{ $url->original_url }}</td>
                                    <td class="px-4 py-2 border truncate max-w-xs"></td>
                                    <td class="px-4 py-2 border">{{ $url->user->name ?? 'N/A' }}</td>
                                    <td class="px-4 py-2 border">{{ $url->created_at }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center px-4 py-4 text-gray-500">No URLs found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                {{-- <div class="mt-4">
                    {{ $urls->links() }}
                </div> --}}
                <div class="mt-4 flex justify-between items-center text-sm text-gray-600">
                    <div>
                        Showing {{ $urls->firstItem() }} to {{ $urls->lastItem() }} of {{ $urls->total() }} results
                    </div>
                    <div>
                        {{ $urls->links() }}                        
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

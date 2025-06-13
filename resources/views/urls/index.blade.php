<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Generated Short URLs
        </h2>
    </x-slot> --}}

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <!-- Top Controls -->
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-4 gap-2">

                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Generated Short URLs
                        @unless(Auth::user()->role === 'superadmin')
                            <a href="{{ route('urls.create') }}">
                                <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Generate</button>
                            </a>
                        @endunless
                    </h2>

                    


                    <form method="GET" action="{{ route('urls.index') }}" class="flex gap-2 items-center">
                        <select name="interval" class="border border-gray-300 rounded px-3 py-2">
                            <option value="this_month" {{ request('interval') == 'this_month' ? 'selected' : '' }}>This Month</option>
                            <option value="last_month" {{ request('interval') == 'last_month' ? 'selected' : '' }}>Last Month</option>
                            <option value="last_week" {{ request('interval') == 'last_week' ? 'selected' : '' }}>Last Week</option>
                            <option value="today" {{ request('interval') == 'today' ? 'selected' : '' }}>Today</option>
                        </select>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Download</button>
                    </form>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Short URL</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Long URL</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Hits</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Created On</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($urls as $url)
                                <tr>
                                    <td class="px-4 py-2">
                                        <a href="{{ url('/s/' . $url->short_code) }}" target="_blank" class="text-blue-600 hover:underline">
                                            {{ url('/' . $url->short_code) }}
                                        </a>
                                    </td>
                                    <td class="px-4 py-2 text-gray-700">{{ $url->original_url }}</td>
                                    <td class="px-4 py-2 text-center">{{ $url->hits ?? 0 }}</td>
                                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($url->created_at)->format('d M \'y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Links -->
                <div class="mt-4">
                    {{ $urls->appends(request()->query())->links() }}
                </div>

                <!-- Showing Count -->
                <p class="mt-2 text-sm text-gray-500">
                    Showing {{ $urls->count() }} of total {{ $urls->total() }}
                </p>

            </div>
        </div>
    </div>
</x-app-layout>

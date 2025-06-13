<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            All Clients
        </h2>
    </x-slot> --}}

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
                <tbody>
                    @forelse ($clients as $client)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-2 border">{{ $client->company_name }}</td>
                            <td class="px-4 py-2 border">{{ $client->email }}</td>
                            <td class="px-4 py-2 border text-center">{{ $client->members_count }}</td>
                            <td class="px-4 py-2 border text-center">{{ $client->total_urls }}</td>
                            <td class="px-4 py-2 border text-center">{{ $client->total_hits }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center py-4 text-gray-500">No clients found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Pagination Info --}}
        @if ($clients instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="mt-4 flex justify-between items-center text-sm text-gray-600">
                <div>
                    Showing {{ $clients->firstItem() }} to {{ $clients->lastItem() }} of {{ $clients->total() }} results
                </div>
                <div>
                    {{ $clients->links() }}
                </div>
            </div>
        @endif


    </div>

    </div>
</x-app-layout>

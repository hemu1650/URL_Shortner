<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">All Team Members</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">
                <div class="mb-4 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-700">Members List</h3>
                    <a href="{{ route('admin.invite') }}">
                        <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                            Invite
                        </button>
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left border border-gray-200">
                        <thead class="bg-gray-100 text-xs text-gray-600 uppercase tracking-wider">
                            <tr>
                                <th class="px-4 py-2 border">Name</th>
                                <th class="px-4 py-2 border">Email</th>
                                <th class="px-4 py-2 border">Role</th>
                                <th class="px-4 py-2 border text-center">Total URLs</th>
                                <th class="px-4 py-2 border text-center">Total Hits</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @forelse ($members as $member)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 border">{{ $member->name }}</td>
                                    <td class="px-4 py-2 border">{{ $member->email }}</td>
                                    <td class="px-4 py-2 border">{{ $member->role }}</td>
                                    <td class="px-4 py-2 border text-center">{{ $member->shortUrls->count() }}</td>
                                    <td class="px-4 py-2 border text-center">{{ $member->shortUrls->sum('hits') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center px-4 py-2 border">No members found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- <div class="mt-4">
                    {{ $members->links() }}
                </div> --}}
                @if ($members instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="mt-4 flex justify-between items-center text-sm text-gray-600">
                    <div>
                        Showing {{ $members->firstItem() }} to {{ $members->lastItem() }} of {{ $members->total() }} results
                    </div>
                    <div>
                        {{ $members->links() }}
                    </div>
                </div>
            @endif

            </div>
        </div>
    </div>
</x-app-layout>

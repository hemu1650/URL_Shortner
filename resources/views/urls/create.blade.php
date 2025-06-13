<x-app-layout>
    

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <!-- Top Controls -->
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-4 gap-2">

                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Generated Short URLs                        
                    </h2>                  

                </div>

                 <form method="POST" action="{{ route('urls.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="original_url" class="block text-gray-700 font-semibold mb-2">Long URL</label>
                            <input
                                type="url"
                                id="original_url"
                                name="original_url"
                                placeholder="e.g. https://sembark.com/travel-software/features/best-itinerary-builder"
                                required
                                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
                            >
                        </div>

                        <div class="text-left">
                            <button
                                type="submit"
                                class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded"
                            >
                                Generate
                            </button>
                        </div>
                    </form>

            </div>
        </div>
    </div>
</x-app-layout>

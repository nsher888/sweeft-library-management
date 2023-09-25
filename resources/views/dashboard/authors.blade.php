<x-layout>
    <x-navigation />

    <div class="container mx-auto mt-6 p-4">
        <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-blue-500 text-white">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold">Author Name</th>
                    <th class="px-6 py-3 text-left font-semibold">Books Count</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($authors as $author)
                <tr>
                    <td class="px-6 py-4">{{ $author->name }}</td>
                    <td class="px-6 py-4">{{ $author->books_count }}</td>

                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="my-4 flex justify-center space-x-4">
            @if ($authors->currentPage() > 1)
            <a href="{{ $authors->previousPageUrl() }}"
                class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition duration-300">Previous</a>
            @endif

            @foreach(range(1, $authors->lastPage()) as $page)
            <a href="{{ $authors->url($page) }}"
                class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition duration-300 @if($page === $authors->currentPage()) bg-blue-700 @endif">{{
                $page }}</a>
            @endforeach

            @if ($authors->hasMorePages())
            <a href="{{ $authors->nextPageUrl() }}"
                class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition duration-300">Next</a>
            @endif

        </div>
    </div>
</x-layout>
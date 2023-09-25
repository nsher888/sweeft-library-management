<x-layout>

    <x-navigation />

    <div class="container mx-auto mt-6 p-4">
        <!-- Book List -->
        <div class="mb-8">
            <div class="flex gap-6 items-center justify-between mb-4">
                <h2 class="text-xl font-semibold">Book List</h2>
                <a href="{{ route('dashboard.store') }}"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-full transition duration-300">Add
                    new book</a>
            </div>
            <ul class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                @foreach ($books as $book)


                <li class="bg-white shadow-lg rounded-lg p-4">
                    <h3 class="text-lg font-semibold mb-2">{{ $book->name }}</h3>
                    <p class="text-gray-600">Author: @foreach ($book->authors as $author)
                        {{ $author->name }}
                        @endforeach</p>
                    <p class="text-gray-600">Publish Year: {{ $book->publication_year }}</p>
                    <p class="{{ $book->available ? 'text-green-600' : 'text-red-600' }}">
                        Status: {{ $book->available ? 'Available' : 'Unavailable' }}
                    </p>
                    <div class="mt-4">
                        <a href="{{ route('books.edit', $book->id) }}"
                            class="bg-blue-500 text-white px-3 py-2 rounded-md">Edit</a>

                        <form class="inline-block" action="{{ route('books.destroy', $book->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-500 text-white px-3 py-2 rounded-md ml-2">Delete</button>
                    </div>
                </li>

                @endforeach
            </ul>
        </div>

        <div class="my-4 flex justify-center space-x-4">
            @if ($books->currentPage() > 1)
            <a href="{{ $books->previousPageUrl() }}"
                class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition duration-300">Previous</a>
            @endif

            @foreach(range(1, $books->lastPage()) as $page)
            <a href="{{ $books->url($page) }}"
                class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition duration-300 @if($page === $books->currentPage()) bg-blue-700 @endif">{{
                $page }}</a>
            @endforeach

            @if ($books->hasMorePages())
            <a href="{{ $books->nextPageUrl() }}"
                class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition duration-300">Next</a>
            @endif
        </div>
    </div>
</x-layout>
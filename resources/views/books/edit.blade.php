<x-layout>

    <x-navigation />

    <div class="container mx-auto mt-6 p-4">
        <div class="bg-white p-6 shadow-xl rounded-lg">
            <h2 class="text-xl font-semibold mb-4">Edit Book</h2>
            <form method="POST" action="{{ route('books.update', $book->id) }}">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2" for="name">Book Name</label>
                    <input class="w-full px-4 py-2 border rounded-lg" type="text" id="name" name="name"
                        value="{{ $book->name }}" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2" for="authors">Author(s) (Separate with ;
                        - semicolon)</label>
                    <input type="text" class="w-full px-4 py-2 border rounded-lg" id="authors" name="authors"
                        value="{{ $book->authors->pluck('name')->implode('; ') }}" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2" for="publication_year">Publish Year</label>
                    <input class="w-full px-4 py-2 border rounded-lg" type="text" id="publication_year"
                        name="publication_year" value="{{ $book->publication_year }}" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Status</label>
                    <div class="flex items-center space-x-4">
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="available" value="1" required
                                class="form-radio accent-green-500 focus:ring-0 focus:ring-offset-0 h-4 w-4" {{
                                $book->available ? 'checked' : '' }}>
                            <span class="text-gray-700 ml-2">Available</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="available" value="0" required
                                class="form-radio accent-red-500 focus:ring-0 focus:ring-offset-0 h-4 w-4" {{
                                $book->available ? '' : 'checked' }}>
                            <span class="text-gray-700 ml-2">Unavailable</span>
                        </label>
                    </div>
                </div>
                <div class="mt-6">
                    <button
                        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-full transition duration-300"
                        type="submit">Update Book</button>
                </div>
            </form>
        </div>

</x-layout>
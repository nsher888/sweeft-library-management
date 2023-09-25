<nav class="bg-blue-500">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-20">
            <a href={{ route('index') }} class="text-white text-2xl font-semibold">Library Management Dashboard</a>
            <ul class="flex space-x-6  items-center">
                <li><a href={{ route('dashboard.authors') }}
                        class="text-white hover:text-gray-300 transition duration-300">Authors List</a></li>

                @if(Route::currentRouteName() === 'index')
                <form action="{{ route('index') }}" method="GET" class="flex items-center space-x-2">
                    @csrf
                    <input type="text" placeholder="Search..." name="search"
                        class="border rounded-full px-4 py-2 focus:outline-none focus:ring focus:border-blue-300"
                        style="min-width: 200px;">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-full transition duration-300">Search</button>
                </form>
                @endif
            </ul>
        </div>
    </div>
</nav>
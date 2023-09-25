<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'publication_year' => 'required|string',
            'available' => 'boolean',
            'authors' => 'required|string',
        ]);

        $authorNames = array_map('trim', explode(';', $validatedData['authors']));

        $authors = [];
        foreach ($authorNames as $authorName) {
            $author = Author::firstOrCreate(['name' => $authorName]);
            $authors[] = $author;
        }

        $book = Book::create([
            'name' => $validatedData['name'],
            'publication_year' => $validatedData['publication_year'],
            'available' => $validatedData['available'],
        ]);

        foreach ($authorNames as $authorName) {
            $author = Author::firstOrCreate(['name' => $authorName]);
            $book->authors()->attach($author->id);
        }

        notify()->success('Book created successfully!');
        return redirect()->route('index');
    }

    public function index(Request $request)
    {

        $search = $request->input('search');

        $query = Book::with('authors')->orderBy('created_at', 'desc');

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
                $q->orWhereHas('authors', function ($authorQuery) use ($search) {
                    $authorQuery->where('name', 'like', '%' . $search . '%');
                });
            });
        }

        $books = $query->paginate(20);

        return view('index', compact('books', 'search'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'publication_year' => 'required|string',
            'available' => 'boolean',
            'authors' => 'required|string',
        ]);

        $authorNames = array_map('trim', explode(';', $validatedData['authors']));

        $book = Book::findOrFail($id);

        $book->update([
            'name' => $validatedData['name'],
            'publication_year' => $validatedData['publication_year'],
            'available' => $validatedData['available'],
        ]);

        $book->authors()->detach();

        foreach ($authorNames as $authorName) {
            $author = Author::firstOrCreate(['name' => $authorName]);
            $book->authors()->attach($author->id);
        }

        notify()->success('Book updated successfully!');
        return redirect()->route('index');
    }


    public function destroy(Book $book)
    {
        $book->delete();
        notify()->success('Book deleted successfully!');
        return redirect()->route('index');
    }

    public function edit(Book $book)
    {
        return view('dashboard.edit', compact('book'));
    }

    public function authorsIndex()
    {
        $authors = Author::select('authors.*')
            ->selectRaw('COUNT(books.id) as books_count')
            ->leftJoin('author_book', 'authors.id', '=', 'author_book.author_id')
            ->leftJoin('books', 'books.id', '=', 'author_book.book_id')
            ->groupBy('authors.id')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('dashboard.authors', compact('authors'));
    }
}

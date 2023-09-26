<?php

namespace App\Http\Controllers;

use App\Http\Requests\Book\StoreBookRequest;
use App\Http\Requests\Book\UpdateBookRequest;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BookController extends Controller
{
	public function index(Request $request): View
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

	public function store(StoreBookRequest $request): RedirectResponse
	{
		$validatedData = $request->validated();

		$authorNames = array_map('trim', explode(';', $validatedData['authors']));

		$authors = [];
		foreach ($authorNames as $authorName) {
			$author = Author::firstOrCreate(['name' => $authorName]);
			$authors[] = $author;
		}

		$book = Book::create([
			'name'             => $validatedData['name'],
			'publication_year' => $validatedData['publication_year'],
			'available'        => $validatedData['available'],
		]);

		foreach ($authorNames as $authorName) {
			$author = Author::firstOrCreate(['name' => $authorName]);
			$book->authors()->attach($author->id);
		}

		notify()->success('Book created successfully!');
		return redirect()->route('books.index');
	}

	public function update(UpdateBookRequest $request, $id): RedirectResponse
	{
		$validatedData = $request->validated();

		$authorNames = array_map('trim', explode(';', $validatedData['authors']));

		$book = Book::findOrFail($id);

		$book->update([
			'name'             => $validatedData['name'],
			'publication_year' => $validatedData['publication_year'],
			'available'        => $validatedData['available'],
		]);

		$book->authors()->detach();

		foreach ($authorNames as $authorName) {
			$author = Author::firstOrCreate(['name' => $authorName]);
			$book->authors()->attach($author->id);
		}

		notify()->success('Book updated successfully!');
		return redirect()->route('books.index');
	}

	public function destroy(Book $book): RedirectResponse
	{
		$book->delete();
		notify()->success('Book deleted successfully!');
		return redirect()->route('books.index');
	}

	public function edit(Book $book): View
	{
		return view('books.edit', compact('book'));
	}
}

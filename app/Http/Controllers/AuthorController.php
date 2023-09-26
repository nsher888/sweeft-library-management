<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Contracts\View\View;

class AuthorController extends Controller
{
	public function index(): View
	{
		$authors = Author::select('authors.*')
			->selectRaw('COUNT(books.id) as books_count')
			->leftJoin('author_book', 'authors.id', '=', 'author_book.author_id')
			->leftJoin('books', 'books.id', '=', 'author_book.book_id')
			->groupBy('authors.id')
			->orderBy('created_at', 'desc')
			->paginate(20);

		return view('authors.index', compact('authors'));
	}
}

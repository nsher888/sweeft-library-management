<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::controller(BookController::class)->group(function () {
	Route::get('/', 'index')->name('books.index');
	Route::view('/books/create', 'books.create')->name('books.create');
	Route::post('/books', 'store')->name('books.store');
	Route::get('/books/{book}/edit', 'edit')->name('books.edit');
	Route::put('/books/{book}', 'update')->name('books.update');
	Route::delete('/books/{book}', 'destroy')->name('books.destroy');
});

Route::get('/authors', [AuthorController::class, 'index'])->name('authors.index');

<?php

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

Route::post('/books', [BookController::class, 'store'])->name('books.store');

Route::get('/', [BookController::class, 'index'])->name('index');
Route::view('/dashboard/store', 'dashboard.store')->name('dashboard.store');

Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');
Route::put('/books/{book}', [BookController::class, 'update'])->name('books.update');
Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');


Route::get('/dashboard/authors', [BookController::class, 'authorsIndex'])->name('dashboard.authors');

Route::delete('/authors/{author}', [BookController::class, 'destroyAuthor'])->name('authors.destroy');

<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Models\Blog;
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

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', function () {
    $blogs = Blog::with('comments','likes', 'user')
        ->withCount('comments', 'likes')
        ->latest()->get();

    $selectedBlog = null;

    if(request()->blog) {
        $selectedBlog = Blog::where('id', request()->blog)
            ->with('comments','likes', 'user')
            ->withCount('comments', 'likes')
            ->first();
    }
    return view('dashboard', compact('blogs', 'selectedBlog'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::resource('blogs', BlogController::class);
    Route::post('/blogs/{blog}/like', [BlogController::class, 'like'])->name('blogs.like');
    Route::post('/blogs/{blog}/comment', [CommentController::class, 'store'])->name('comments.store');
    Route::resource('comments', CommentController::class)->except(['store']);

});

require __DIR__.'/auth.php';

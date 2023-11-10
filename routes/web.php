<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Guest\PageController as GuestPageController;

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

Route::get('/', [GuestPageController::class, 'index'])->name('guest.home');
// Route::get('/posts/all', [GuestPageController::class, 'all_posts'])->name('guest.posts.all');
// Route::get('/posts/{slug}', [GuestPageController::class, 'detail_post'])->name('guest.posts.detail');

Route::middleware(['auth', 'verified'])
  ->prefix('admin')
  ->name('admin.')
  ->group(function () {

    Route::get('/', [AdminPageController::class, 'index'])->name('home');

    // # ROTTE POST RESOURCE
    Route::get('/posts/trash', [PostController::class, 'trash'])->name('posts.trash.index');
    Route::patch('/posts/trash/{post}/restore', [PostController::class, 'restore'])->name('posts.trash.restore');
    Route::delete('/posts/trash/{post}', [PostController::class, 'forceDestroy'])->name('posts.trash.force-destroy');
    Route::delete('/posts/{post}/delete-image', [PostController::class, 'deleteImage'])->name('posts.delete-image');
    Route::patch('/posts/{post}/publish', [PostController::class, 'publish'])->name('posts.publish');
    Route::resource('posts', PostController::class);
  });

require __DIR__ . '/auth.php';
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
Route::get('/posts/all', [GuestPageController::class, 'all_posts'])->name('guest.posts.all');
Route::get('/posts/{slug}', [GuestPageController::class, 'detail_post'])->name('guest.posts.detail');

Route::middleware(['auth', 'verified'])
  ->prefix('admin')
  ->name('admin.')
  ->group(function () {

    Route::get('/', [AdminPageController::class, 'index'])->name('home');

    Route::resource('posts', PostController::class);

  });

require __DIR__ . '/auth.php';
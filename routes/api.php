<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\MessageFormController;
use App\Http\Controllers\Api\AuthorController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// # POST API
Route::apiResource("posts", PostController::class)->only(["index", "show"]);
Route::get('/posts-by-category/{category_id}', [PostController::class, 'postsByCategory']);
Route::post('/get-posts-by-filters', [PostController::class, 'postsByFilters']);
Route::get('/posts-featured', [PostController::class, 'postsFeatured']);

// # AUTHOR API
Route::apiResource('authors', AuthorController::class)->only(['index']);

// # CATEGORY API
Route::apiResource("categories", CategoryController::class)->only(["index", "show"]);


// # TAGS API
Route::apiResource("tags", TagController::class)->only(["index"]);


// # MESSAGE FORM API
Route::post("/message", [MessageFormController::class, 'store']);
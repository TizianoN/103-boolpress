<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Post;

class PageController extends Controller
{
  public function index()
  {
    $title = "Featured posts";
    $posts = Post::orderByDesc('created_at')->limit(8)->get();
    return view('guest.home', compact('title', 'posts'));
  }

  public function all_posts()
  {
    $title = "All posts";
    $posts = Post::orderByDesc('created_at')->paginate(8);
    return view('guest.all-posts', compact('title', 'posts'));
  }

  public function detail_post(string $slug)
  {
    $post = Post::where('slug', $slug)->first();
    if (!$post)
      abort(404);

    return view('guest.detail-post', compact('post'));
  }
}
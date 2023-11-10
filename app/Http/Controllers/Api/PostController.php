<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;


class PostController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $posts = Post::select("id", "category_id", "title", "slug", "content", "cover_image")
      ->where('published', 1)
      ->with('tags:id,color,label', 'category:id,color,label')
      ->orderByDesc('id')
      ->paginate(12);

    foreach ($posts as $post) {
      $post->content = $post->getAbstract(200);
      $post->cover_image = $post->getAbsUriImage();
    }

    return response()->json($posts);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */

  public function show($slug)
  {
    $post = Post::select("id", "category_id", "title", "slug", "content", "cover_image")
      ->where('slug', $slug)
      ->where('published', 1)
      ->with('tags:id,color,label', 'category:id,color,label')
      ->first();

    if (!$post)
      abort(404, "Post not found");

    $post->cover_image = $post->getAbsUriImage();

    return response()->json($post);
  }

  public function postsByCategory($category_id)
  {
    $posts = Post::select("id", "category_id", "title", "slug", "content", "cover_image")
      ->where("category_id", $category_id)
      ->where('published', 1)
      ->with('tags:id,color,label', 'category:id,color,label')
      ->orderByDesc('id')
      ->paginate(12);

    foreach ($posts as $post) {
      $post->content = $post->getAbstract(200);
      $post->cover_image = $post->getAbsUriImage();
    }

    return response()->json($posts);
  }

  public function postsByFilters(Request $request)
  {
    $filters = $request->all();

    $posts_query = Post::select("id", "category_id", "title", "slug", "content", "cover_image")
      ->where('published', 1)
      ->with('tags:id,color,label', 'category:id,color,label')
      ->orderByDesc('id');

    if (!empty($filters['activeCategories'])) {
      $posts_query->whereIn('category_id', $filters['activeCategories']);
    }

    if (!empty($filters['activeTags'])) {
      foreach ($filters['activeTags'] as $tag) {
        $posts_query->whereHas('tags', function ($query) use ($tag) {
          $query->where('tag_id', $tag);
        });
      }
    }

    $posts = $posts_query->paginate(12);

    return response()->json($posts);
  }

  public function postsFeatured()
  {
    $posts = Post::select("id", "category_id", "title", "slug", "content", "cover_image")
      ->where('featured', 1)
      ->where('published', 1)
      ->with('tags:id,color,label', 'category:id,color,label')
      ->limit(5)
      ->get();


    return response()->json($posts);
  }
}
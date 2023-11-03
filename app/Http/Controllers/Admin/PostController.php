<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Mail\PostPublished;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;





class PostController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $posts = Post::orderByDesc('id')->paginate(12);
    return view('admin.posts.index', compact('posts'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $categories = Category::all();
    $tags = Tag::all();
    return view('admin.posts.create', compact('categories', 'tags'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * * @return \Illuminate\Http\Response
   */
  public function store(StorePostRequest $request)
  {
    $data = $request->validated();

    $post = new Post();
    $post->fill($data);
    $post->slug = Str::slug($post->title);

    if ($request->hasFile('cover_image')) {
      $cover_image_path = Storage::put('uploads/posts/cover_image', $data['cover_image']);
      $post->cover_image = $cover_image_path;
    }

    $post->save();


    if (Arr::exists($data, 'tags')) {
      $post->tags()->attach($data["tags"]);
    }

    return redirect()->route('admin.posts.show', $post);
  }

  /**
   * Display the specified resource.
   *
   * @param  Post $post
   * * @return \Illuminate\Http\Response
   */
  public function show(Post $post)
  {
    return view('admin.posts.show', compact('post'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  Post $post
   * * @return \Illuminate\Http\Response
   */
  public function edit(Post $post)
  {
    $categories = Category::all();
    $tags = Tag::all();
    $tag_ids = $post->tags->pluck('id')->toArray();

    return view('admin.posts.edit', compact('post', 'categories', 'tags', 'tag_ids'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  Post $post
   * * @return \Illuminate\Http\Response
   */
  public function update(UpdatePostRequest $request, Post $post)
  {
    $data = $request->validated();

    $post->fill($data);
    $post->slug = Str::slug($post->title);

    if ($request->hasFile('cover_image')) {
      if ($post->cover_image) {
        Storage::delete($post->cover_image);
      }

      $cover_image_path = Storage::put('uploads/posts/cover_image', $data['cover_image']);
      $post->cover_image = $cover_image_path;
    }

    $post->save();

    if (Arr::exists($data, 'tags')) {
      $post->tags()->sync($data["tags"]);
    } else {
      $post->tags()->detach();
    }

    return redirect()->route('admin.posts.show', $post);
  }

  /**
   * Soft deletes the specified resource from storage.
   *
   * @param  Post $post
   * * @return \Illuminate\Http\Response
   */
  public function destroy(Post $post)
  {
    $post->delete();
    return redirect()->route('admin.posts.index');
  }

  /**
   * Display a listing of the deleted resource.
   *
   * * @return \Illuminate\Http\Response
   */
  public function trash()
  {
    $posts = Post::orderByDesc('id')->onlyTrashed()->paginate(12);
    return view('admin.posts.trash.index', compact('posts'));
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  Post $post
   * * @return \Illuminate\Http\Response
   */
  public function forceDestroy(int $id)
  {
    $post = Post::onlyTrashed()->findOrFail($id);
    $post->tags()->detach();

    if ($post->cover_image) {
      Storage::delete($post->cover_image);
    }

    $post->forceDelete();
    return redirect()->route('admin.posts.trash.index');
  }


  /**
   * Restore the specified resource from storage.
   *
   * @param  Post $post
   * * @return \Illuminate\Http\Response
   */
  public function restore(int $id)
  {
    $post = Post::onlyTrashed()->findOrFail($id);
    $post->restore();
    return redirect()->route('admin.posts.trash.index');
  }

  public function deleteImage(Post $post)
  {
    Storage::delete($post->cover_image);
    $post->cover_image = null;
    $post->save();
    return redirect()->back();
  }

  public function publish(Post $post, Request $request)
  {
    $data = $request->all();
    $post->published = !Arr::exists($data, 'published') ? 1 : null;
    $post->save();

    // TODO: DA AGGIUNGERE INVIO EMAIL
    $user = Auth::user();
    $published_post_mailable = new PostPublished($post);
    Mail::to($user->email)->send($published_post_mailable);

    return redirect()->back();
  }
}
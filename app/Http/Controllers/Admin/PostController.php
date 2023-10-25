<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Models\Category;

use Illuminate\Http\Request;
use Illuminate\Support\Str;


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
    return view('admin.posts.create', compact('categories'));
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

    // $post->title = $data['title'];
    // $post->content = $data['content'];

    $post->fill($data);

    $post->slug = Str::slug($post->title);
    $post->save();

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
    return view('admin.posts.edit', compact('post', 'categories'));
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
    $post->save();

    return redirect()->route('admin.posts.show', $post);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  Post $post
   * * @return \Illuminate\Http\Response
   */
  public function destroy(Post $post)
  {
    $post->delete();
    return redirect()->route('admin.posts.index');
  }
}
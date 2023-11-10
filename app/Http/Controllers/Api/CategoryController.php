<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;

class CategoryController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $categories = Category::select('id', 'color', 'label')->get();
    return response()->json($categories);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $category = Category::select('id', 'color', 'label')
      ->where('id', $id)
      ->first();

    if (!$category)
      abort(404, "Category not found");

    return response()->json($category);
  }
}
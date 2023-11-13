<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Post extends Model
{
  use HasFactory, SoftDeletes;

  protected $fillable = ['title', 'content', 'category_id'];

  public function category()
  {
    return $this->belongsTo(Category::class);
  }

  public function author()
  {
    return $this->belongsTo(User::class);
  }

  public function tags()
  {
    return $this->belongsToMany(Tag::class);
  }

  public function setUniqueSlug()
  {
    $slug = Str::slug($this->title);
    $end_slug = "";

    $existing_post = Post::where('slug', $slug)
      ->where('id', '<>', $this->id)
      ->first();

    $i = 1;
    while (!empty($existing_post)) {
      $i++;
      $end_slug = "-" . $i;

      $existing_post = Post::where('slug', $slug . $end_slug)
        ->where('id', '<>', $this->id)
        ->first();
    }


    $this->slug = $slug . $end_slug;
  }

  public function getCategoryBadge()
  {
    return $this->category ? "<span class='badge' style='background-color: {$this->category->color}'>{$this->category->label}</span>" : "";
  }

  public function getTagBadges()
  {
    $badges_html = "";
    foreach ($this->tags as $tag) {
      $badges_html .= "<span class='badge rounded-pill mx-1' style='background-color: {$tag->color}'>{$tag->label}</span>";
    }

    return $badges_html;
  }

  public function getAbstract($chars = 50)
  {
    return strlen($this->content) > $chars ? substr($this->content, 0, $chars) . "..." : $this->content;
  }

  public function getAbsUriImage()
  {
    return $this->cover_image ? Storage::url($this->cover_image) : null;
  }
}
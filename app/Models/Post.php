<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
  use HasFactory, SoftDeletes;

  protected $fillable = ['title', 'content', 'category_id'];

  public function category()
  {
    return $this->belongsTo(Category::class);
  }

  public function tags()
  {
    return $this->belongsToMany(Tag::class);
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
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
  use HasFactory;

  protected $fillable = ['title', 'content', 'category_id'];

  public function category()
  {
    return $this->belongsTo(Category::class);
  }

  public function getCategoryBadge()
  {
    return $this->category ? "<span class='badge' style='background-color: {$this->category->color}'>{$this->category->label}</span>" : "";
  }

  public function getAbstract($chars = 50)
  {
    return strlen($this->content) > $chars ? substr($this->content, 0, $chars) . "..." : $this->content;
  }
}
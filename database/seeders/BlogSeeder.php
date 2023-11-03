<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Category;
use App\Models\Tag;
use App\Models\Post;

class BlogSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    // # creo le categorie
    $categories = Category::factory()->count(10)->create();

    // # creo i tags
    $tags = Tag::factory()->count(10)->create();

    // # creo post "normali"
    $posts = Post::factory()
      ->useExistingCategory()
      ->hasAttached($tags->random(3))
      ->count(200)
      ->create();

    // # creo post in evidenza
    $featured_posts = Post::factory()
      ->useExistingCategory()
      ->hasAttached($tags->random(3))
      ->featured()
      ->count(5)
      ->create();

    // # creo post cestinati
    $trashed_posts = Post::factory()
      ->useExistingCategory()
      ->hasAttached($tags->random(3))
      ->trashed()
      ->count(50)
      ->create();
  }
}
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
    for ($i = 0; $i < 40; $i++) {
      $posts = Post::factory()
        ->useExistingCategory()
        ->hasAttached($tags->random(3))
        ->count(5)
        ->create();
    }

    // # creo post in evidenza
    for ($i = 0; $i < 5; $i++) {
      $featured_posts = Post::factory()
        ->useExistingCategory()
        ->hasAttached($tags->random(3))
        ->featured()
        ->count(1)
        ->create();
    }

    // # creo post cestinati
    for ($i = 0; $i < 10; $i++) {
      $trashed_posts = Post::factory()
        ->useExistingCategory()
        ->hasAttached($tags->random(3))
        ->trashed()
        ->count(5)
        ->create();
    }
  }
}
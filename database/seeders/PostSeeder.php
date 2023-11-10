<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

use Faker\Generator as Faker;

class PostSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run(Faker $faker)
  {
    $category_ids = Category::all()->pluck('id');
    $category_ids[] = null;

    $tag_ids = Tag::all()->pluck('id');

    for ($i = 0; $i < 100; $i++) {
      $post = new Post();
      $post->category_id = $faker->randomElement($category_ids);
      $post->title = $faker->catchPhrase();
      $post->content = $faker->paragraphs(3, true);
      $post->setUniqueSlug();
      $post->save();

      $post->tags()->attach($faker->randomElements($tag_ids, rand(0, 3)));
    }
  }
}
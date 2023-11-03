<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Tag;

use Faker\Generator as Faker;

class TagSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run(Faker $faker)
  {
    $_tags = ["html", "css", "bootstrap", "sass", "js", "vue", "php", "mysql", "laravel", "markdown"];

    foreach ($_tags as $_tag) {
      $tag = new Tag();
      $tag->label = $_tag;
      $tag->color = $faker->hexColor();
      $tag->save();
    }
  }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Category;

use Faker\Generator;

class CategorySeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run(Generator $faker)
  {
    $_categories = [
      "Archeologia",
      "Medioevo",
      "Manierismo",
      "Ottocento",
      "Novecento",
      "Contemporanea",
      "Scultura",
      "Disegni",
      "Artisti",
      "Collezioni",
    ];

    foreach ($_categories as $_category) {
      $category = new Category();
      $category->label = $_category;
      $category->color = $faker->hexColor();
      $category->save();
    }
  }
}
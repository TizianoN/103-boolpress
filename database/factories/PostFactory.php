<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition()
  {
    $title = fake()->catchPhrase();
    $slug = Str::slug($title);
    $content = fake()->paragraphs(3, true);

    return [
      'title' => $title,
      'slug' => $slug,
      'content' => $content,
      'published' => rand(0, 1),
    ];
  }

  /**
   * Indicate that the post is featured.
   *
   * @return \Illuminate\Database\Eloquent\Factories\Factory
   */
  public function featured()
  {
    return $this->state(function (array $attributes) {
      return [
        'featured' => 1,
      ];
    });
  }

  /**
   * Indicate that the post is featured.
   *
   * @return \Illuminate\Database\Eloquent\Factories\Factory
   */
  public function useExistingCategory()
  {
    return $this->state(function (array $attributes) {
      $categories = Category::all()->pluck('id');

      return [
        'category_id' => fake()->randomElement($categories),
      ];
    });
  }
}
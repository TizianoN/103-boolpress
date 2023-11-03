<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

use App\Models\Post;

class UpdateFeaturedPosts extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'update:featured-posts';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Update featured posts';

  /**
   * Execute the console command.
   *
   * @return int
   */
  public function handle()
  {
    $featured_posts = Post::where('featured', 1)->get();
    foreach ($featured_posts as $post) {
      $post->featured = 0;
      $post->save();
    }

    $new_featured_posts = Post::inRandomOrder()->limit(5)->get();
    foreach ($new_featured_posts as $post) {
      $post->featured = 1;
      $post->save();
    }

    echo "Featured Post aggiornati con successo. I nuovi featured posts sono:\n";
    foreach ($new_featured_posts as $index => $post) {
      echo "Post $index: $post->id\n";
    }

    Log::info("Featured Post aggiornati con successo.");

    return Command::SUCCESS;
  }
}
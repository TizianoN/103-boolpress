<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;

use Faker\Generator as Faker;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run(Faker $faker)
  {
    $user = new User();
    $user->name = "Admin";
    $user->email = "admin@email.it";
    $user->password = Hash::make("password");
    $user->save();

    for ($i = 0; $i < 5; $i++) {
      $user = new User();
      $user->name = $faker->firstName();
      $user->email = $faker->email();
      $user->password = Hash::make("password");
      $user->save();
    }
  }
}
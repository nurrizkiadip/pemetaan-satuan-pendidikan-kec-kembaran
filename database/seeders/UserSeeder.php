<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    //admin
    $admin = [
      'name' => 'Admin',
      'email' => 'admin@gmail.com',
      'email_verified_at' => now(),
      'password' => Hash::make('password'), // password
      'remember_token' => Str::random(10),
    ];

    $admin = User::create($admin);
  }
}

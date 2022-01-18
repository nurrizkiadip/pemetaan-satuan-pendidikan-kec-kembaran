<?php

namespace Database\Seeders;

use App\Models\SchoolLevel;
use Illuminate\Database\Seeder;

class SchoolLevelSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $levels = [
      [
        'name' => 'MAS',
        'icon' => null,
      ],
      [
        'name' => 'MIN',
        'icon' => null,
      ],
      [
        'name' => 'MIS',
        'icon' => null,
      ],
      [
        'name' => 'MTsS',
        'icon' => null,
      ],
      [
        'name' => 'SD',
        'icon' => null,
      ],
      [
        'name' => 'SMK',
        'icon' => null,
      ],
      [
        'name' => 'SMKS',
        'icon' => null,
      ],
      [
        'name' => 'SMP',
        'icon' => null,
      ],
    ];

    foreach ($levels as $level) {
      SchoolLevel::create($level);
    }
  }
}

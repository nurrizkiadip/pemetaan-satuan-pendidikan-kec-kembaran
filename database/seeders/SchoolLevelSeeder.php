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
        'icon' => 'school-level/icon/mts.png',
      ],
      [
        'name' => 'SD',
        'icon' => 'school-level/icon/sd.png',
      ],
      [
        'name' => 'SMK',
        'icon' => 'school-level/icon/sma.png',
      ],
      [
        'name' => 'SMKS',
        'icon' => null,
      ],
      [
        'name' => 'SMP',
        'icon' => 'school-level/icon/smp.png',
      ],
    ];

    foreach ($levels as $level) {
      SchoolLevel::create($level);
    }
  }
}

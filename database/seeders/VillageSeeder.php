<?php

namespace Database\Seeders;

use App\Models\Village;
use Illuminate\Database\Seeder;

class VillageSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $villages = [
      [
        'name' => 'Bantarwuni',
        'geojson_path' => 'villages/geojson/bantarwuni.geojson',
      ],
      [
        'name' => 'Bojongsari',
        'geojson_path' => 'villages/geojson/Bojongsari.geojson',
      ],
      [
        'name' => 'Dukuhwaluh',
        'geojson_path' => 'villages/geojson/dukuhwaluh.geojson',
      ],
      [
        'name' => 'Karangsari',
        'geojson_path' => 'villages/geojson/Karangsari.geojson',
      ],
      [
        'name' => 'Karangsoka',
        'geojson_path' => 'villages/geojson/Karangsoka.geojson',
      ],
      [
        'name' => 'Karangtengah',
        'geojson_path' => 'villages/geojson/Karangtengah.geojson',
      ],
      [
        'name' => 'Kembaran',
        'geojson_path' => 'villages/geojson/Kembaran.geojson',
      ],
      [
        'name' => 'Kramat',
        'geojson_path' => 'villages/geojson/Kramat.geojson',
      ],
      [
        'name' => 'Ledug',
        'geojson_path' => 'villages/geojson/Ledug.geojson',
      ],
      [
        'name' => 'Linggasari',
        'geojson_path' => 'villages/geojson/Linggasari.geojson',
      ],
      [
        'name' => 'Pliken',
        'geojson_path' => 'villages/geojson/Pliken.geojson',
      ],
      [
        'name' => 'Purbadana',
        'geojson_path' => 'villages/geojson/Purbadana.geojson',
      ],
      [
        'name' => 'Purwodadi',
        'geojson_path' => 'villages/geojson/Purwodadi.geojson',
      ],
      [
        'name' => 'Sambeng Kulon',
        'geojson_path' => 'villages/geojson/Sambeng_Kulon.geojson',
      ],
      [
        'name' => 'Sambeng Wetan',
        'geojson_path' => 'villages/geojson/Sambeng_Wetan.geojson',
      ],
      [
        'name' => 'Tambaksari',
        'geojson_path' => 'villages/geojson/Tambaksari.geojson',
      ],
    ];

    foreach ($villages as $village) {
      Village::factory()->create([
        'name' => \Str::title($village['name']),
        'geojson_path' => strtolower($village['geojson_path']),
      ]);
    }
  }
}

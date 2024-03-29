<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class VillageFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'color' => $this->faker->hexColor
    ];
  }
}

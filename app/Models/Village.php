<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
    'color',
    'geojson_path',
  ];

  public function schools()
  {
    return $this->hasMany(School::class);
  }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
    'address',
    'status',
    'lat',
    'lang',
    'logo_photo_path',
    'school_level_id',
    'village_id',
  ];

  public function setStatusAttribute($value) {
    $this->attributes['status'] = strtoupper($value);
  }

  public function village()
  {
    return $this->belongsTo(Village::class);
  }

  public function schoolLevel()
  {
    return $this->belongsTo(SchoolLevel::class);
  }
}

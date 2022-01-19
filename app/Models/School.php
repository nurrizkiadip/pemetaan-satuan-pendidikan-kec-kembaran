<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

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

  /**
   * Update the user's profile photo.
   *
   * @param  \Illuminate\Http\UploadedFile  $photo
   * @return void
   */
  public function updatePhoto(UploadedFile $photo)
  {
    tap($this->logo_photo_path, function ($previous) use ($photo) {
      $this->forceFill([
        'logo_photo_path' => $photo->storePublicly(
            'schools/logo',
            ['disk' => 'public']
          ),
      ])->save();

      if ($previous) {
        Storage::disk('public')->delete($previous);
      }
    });
  }

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

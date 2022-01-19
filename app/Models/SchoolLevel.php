<?php

namespace App\Models;

use GuzzleHttp\Psr7\UploadedFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SchoolLevel extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
    'icon'
  ];

  public function updateIcon(UploadedFile $icon)
  {
    tap($this->icon, function ($previous) use ($icon) {
      $this->forceFill([
        'icon' => $icon->storePublicly(
            'schoolLevels/icon',
            ['disk' => 'public']
          ),
      ])->save();

      if ($previous) {
        Storage::disk('public')->delete($previous);
      }
    });
  }

  public function schools()
  {
    return $this->hasMany(School::class);
  }
}

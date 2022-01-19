<?php

namespace App\Models;

use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Village extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
    'color',
    'geojson_path',
  ];

  public function updateGeoJSON(UploadedFile $file, String $filename)
  {
    tap($this->geojson_path, function ($previous) use ($file, $filename) {
      $this->forceFill([
        'geojson_path' => $file->storePubliclyAs(
            'villages/geojson',
            $filename,
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

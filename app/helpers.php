<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists('parse_date_to_iso_format')) {
  function parse_date_to_iso_format($stringDate): string
  {
    return \Carbon\Carbon::parse($stringDate)
      ->locale(config('app.locale'))
      ->timezone(config('app.timezone'))
      ->isoFormat('LL');
  }
}

if (!function_exists('parse_date_to_sql_date_format')) {
  function parse_date_to_sql_date_format($stringDate): string
  {
    return \Carbon\Carbon::parse($stringDate)
      ->locale(config('app.locale'))
      ->timezone(config('app.timezone'))
      ->format('Y-m-d');
  }
}

if (!function_exists('get_file_from_public_storage')) {
  function get_file_from_public_storage($path): string
  {
    return Storage::disk(
      isset($_ENV['VAPOR_ARTIFACT_NAME']) ?
        's3' : 'public'
    )->url($path);
  }
}

if (!function_exists('file_from_public_storage_exists')) {
  function file_from_public_storage_exists($path): string
  {
    return Storage::disk(
      isset($_ENV['VAPOR_ARTIFACT_NAME']) ?
        's3' : 'public'
    )->exists($path);
  }
}

if (!function_exists('get_datetime')) {
  function get_datetime(): string
  {
    $now = now();
    return $now->hour . "_" . $now->minute .
      "_" . $now->second . "_" . $now->millisecond .
      "_" . $now->day . "_" . $now->month . "_" . $now->year;
  }
}
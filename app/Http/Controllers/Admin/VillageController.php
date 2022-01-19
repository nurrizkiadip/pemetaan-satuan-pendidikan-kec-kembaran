<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VillageController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Contracts\View\View
   */
  public function index()
  {
    $villages = Village::withCount(['schools'])->get();
    return view('admin.village.index', compact(
      'villages'
    ));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Contracts\View\View
   */
  public function create()
  {
    return view('admin.village.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function store(Request $request)
  {
    $validatedInput = $request->validate([
      'name' => ['required', 'unique:villages,name'],
      'color' => ['required', 'unique:villages,color'],
      'geojson' => ['required'],
    ]);
    
    $validatedInput['geojson_path'] = $validatedInput['geojson'];
    $villageCreated = Village::create($validatedInput);
    if ($validatedInput['geojson'] !== null) {
      $filename = strtolower(\Str::replace(' ', '_', $validatedInput['name']) .
        "_" . get_datetime() . ".geojson");
      $villageCreated->updateGeoJSON($validatedInput['geojson'], $filename);
    }

    return redirect()->route('admin.village.index')->with([
      'status' => 'success',
      'message' => "Kelurahan <b>$villageCreated->name</b> berhasil dibuat"
    ]);
  }

  /**
   * Display the specified resource.
   *
   * @param \App\Models\Village $village
   * @return \Illuminate\Contracts\View\View
   */
  public function show(Village $village)
  {
    $schools = $village->schools;
    return view('admin.village.show', compact('village', 'schools'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param \App\Models\Village $village
   * @return \Illuminate\Contracts\View\View
   */
  public function edit(Village $village)
  {
    return view('admin.village.edit', compact('village'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\Village $village
   * @return \Illuminate\Http\RedirectResponse
   */
  public function update(Request $request, Village $village)
  {
    $rules = [
      'name' => ['required'],
      'color' => ['required'],
      'geojson' => ['required'],
    ];
    if ($village->name !== $request->name) $rules['name'][] = 'unique:villages,name';
    if ($village->color !== $request->color) $rules['color'][] = 'unique:villages,color';
    $validatedInput = $request->validate($rules);

    if ($validatedInput['geojson'] !== null) {
      $filename = strtolower(\Str::replace(' ', '_', $validatedInput['name']) .
        "_" . get_datetime() . ".geojson");
      $village->updateGeoJSON($validatedInput['geojson'], $filename);
      unset($validatedInput['geojson']);
    }

    $village->update($validatedInput);

    return redirect()->route('admin.village.index')->with([
      'status' => 'success',
      'message' => "Kelurahan <b>$village->name</b> berhasil diupdate"
    ]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param \App\Models\Village $village
   * @return \Illuminate\Http\RedirectResponse
   */
  public function destroy(Village $village)
  {
    if (file_from_public_storage_exists($village->geojson_path)) {
      Storage::disk('public')->delete($village->geojson_path);
    }
    $village->delete();

    return back()->with([
      'status' => "success",
      'message' => "Kelurahan <b>$village->name</b> berhasil dihapus",
    ]);
  }
}

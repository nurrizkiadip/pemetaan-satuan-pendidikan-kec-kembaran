<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\SchoolLevel;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SchoolController extends Controller
{
  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Contracts\View\View
   */
  public function create(Village $village)
  {
    $schoolLevels = SchoolLevel::all();

    return view('admin.school.create', compact(
      'village', 'schoolLevels'
    ));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @param Village $village
   * @return \Illuminate\Http\RedirectResponse
   */
  public function store(Request $request, Village $village)
  {
    $validatedInput = $request->validate([
      'name' => ['required', "unique:schools,name"],
      'address' => ['required', "unique:schools,address"],
      'status' => ['required'],
      'lat' => ['required', "unique:schools,lat"],
      'lang' => ['required', "unique:schools,lang"],
      'logo_photo_path' => ['sometimes', 'file', 'max:1024'],
      'school_level_id' => ['required'],
    ]);

    $schoolCreated = $village->schools()->save(
      new School($validatedInput)
    );
    if (isset($validatedInput['logo_photo_path'])) {
      $schoolCreated->updatePhoto($validatedInput['logo_photo_path']);
    }

    return redirect()
      ->route('admin.village.show', [$village->id])
      ->with([
        'status' => 'success',
        'message' => "Sekolah <b>$schoolCreated->name</b> berhasil dibuat"
      ]);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param Village $village
   * @param \App\Models\School $school
   * @return \Illuminate\Contracts\View\View
   */
  public function edit(Village $village, School $school)
  {
    $schoolLevels = SchoolLevel::all();
    return view('admin.school.edit', compact(
      'village', 'school', 'schoolLevels'
    ));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @param Village $village
   * @param \App\Models\School $school
   * @return \Illuminate\Http\RedirectResponse
   */
  public function update(Request $request, Village $village, School $school)
  {
    $rules = [
      'name' => ['required'],
      'address' => ['required'],
      'status' => ['required'],
      'lat' => ['required'],
      'lang' => ['required'],
      'logo_photo_path' => ['sometimes', 'file', 'max:1024'],
      'school_level_id' => ['required'],
    ];

    if ($school->name !== $request->name) $rules['name'][] = "unique:schools,name";
    if ($school->address !== $request->address) $rules['address'][] = "unique:schools,address";
    if ($school->lat !== $request->lat) $rules['lat'][] = "unique:schools,lat";
    if ($school->lang !== $request->lang) $rules['lang'][] = "unique:schools,lang";

    $validatedInput = $request->validate($rules);

    if (isset($validatedInput['logo_photo_path'])) {
      $school->updatePhoto($validatedInput['logo_photo_path']);
      unset($validatedInput['logo_photo_path']);
    }

    $school->update($validatedInput);

    return redirect()
      ->route('admin.village.show', [$village->id])
      ->with([
        'status' => 'success',
        'message' => "Sekolah <b>$school->name</b> berhasil diupdate"
      ]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param Village $village
   * @param \App\Models\School $school
   * @return \Illuminate\Http\RedirectResponse
   */
  public function destroy(Village $village, School $school)
  {
    if (file_from_public_storage_exists($school->logo_photo_path)) {
      Storage::disk('public')->delete($school->logo_photo_path);
    }
    $school->delete();

    return back()->with([
      'status' => 'success',
      'message' => "Sekolah <b>$school->name</b> berhasil dihapus"
    ]);
  }
}

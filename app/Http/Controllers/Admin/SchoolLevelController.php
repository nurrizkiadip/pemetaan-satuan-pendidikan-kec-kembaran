<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SchoolLevelController extends Controller
{
  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Contracts\View\View
   */
  public function create()
  {
    return view('admin.school-level.create');
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
      'name' => ['required', 'unique:school_levels,name'],
      'icon' => ['sometimes'],
    ]);

    $schoolLevelCreated = SchoolLevel::create($validatedInput);
    if (isset($validatedInput['icon'])) {
      $schoolLevelCreated->updateIcon($validatedInput['icon']);
    }

    return redirect()->route('admin.school-level.index')->with([
      'status' => 'success',
      'message' => "Jenjang Sekolah <b>$schoolLevelCreated->name</b> berhasil dibuat"
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param \App\Models\SchoolLevel $schoolLevel
   * @return \Illuminate\Contracts\View\View
   */
  public function edit(SchoolLevel $schoolLevel)
  {
    return view('admin.school-level.edit', compact('schoolLevel'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\SchoolLevel $schoolLevel
   * @return \Illuminate\Http\RedirectResponse
   */
  public function update(Request $request, SchoolLevel $schoolLevel)
  {
    $rules = [
      'name' => ['required'],
      'icon' => ['sometimes'],
    ];

    if ($schoolLevel->name !== $request->name) $rules['name'][] = 'unique:school_levels,name';

    $validatedInput = $request->validate($rules);
    if (isset($validatedInput['icon'])) {
      $schoolLevel->updateIcon($validatedInput['icon']);
      unset($validatedInput['icon']);
    }

    $schoolLevel->update($validatedInput);

    return redirect()->route('admin.school-level.index')->with([
      'status' => 'success',
      'message' => "Jenjang Sekolah <b>$schoolLevel->name</b> berhasil diupdate"
    ]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param \App\Models\SchoolLevel $schoolLevel
   * @return \Illuminate\Http\RedirectResponse
   */
  public function destroy(SchoolLevel $schoolLevel)
  {
    if (file_from_public_storage_exists($schoolLevel->icon)) {
      Storage::disk('public')->delete($schoolLevel->icon);
    }
    $schoolLevel->delete();

    return back()->with([
      'status' => "success",
      'message' => "Jenjang Sekolah <b>$schoolLevel->name</b> berhasil dihapus",
    ]);
  }
}

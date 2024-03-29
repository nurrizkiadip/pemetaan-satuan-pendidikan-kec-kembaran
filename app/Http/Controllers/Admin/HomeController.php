<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\SchoolLevel;
use App\Models\Village;
use Illuminate\Http\Request;

class HomeController extends Controller
{
  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function index()
  {
    $villagesCount = Village::count();
    $schoolLevels = SchoolLevel::withCount(['schools'])->orderBy('name')->get();
    $schools = School::get('status');
    return view('admin.home', compact(
      'villagesCount', 'schoolLevels', 'schools'
    ));
  }
}

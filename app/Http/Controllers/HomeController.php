<?php

namespace App\Http\Controllers;

use App\Models\School;
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
    $villages = Village::all();
    $schools = School::with(['village', 'schoolLevel'])->get();
    return view('guest.home', compact(
      'villages', 'schools'
    ));
  }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
  /*
  |--------------------------------------------------------------------------
  | Login Controller
  |--------------------------------------------------------------------------
  |
  | This controller handles authenticating users for the application and
  | redirecting them to your home screen. The controller uses a trait
  | to conveniently provide its functionality to your applications.
  |
  */

  use AuthenticatesUsers;

  /**
   * Where to redirect users after login.
   *
   * @var string
   */
  protected $redirectTo = RouteServiceProvider::ADMIN_HOME;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('guest')->except('logout');
  }

  public function showLoginForm()
  {
    $canRegister = false;
    return view('auth.login', compact('canRegister'));
  }

  public function redirectPath()
  {
    if (method_exists($this, 'redirectTo')) {
      return $this->redirectTo();
    }

    return property_exists($this, 'redirectTo') ? $this->redirectTo : RouteServiceProvider::HOME;
  }

  public function logout(Request $request)
  {
    $this->guard()->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    if ($response = $this->loggedOut($request)) {
      return $response;
    }

    return $request->wantsJson()
      ? new JsonResponse([], 204)
      : redirect()->route('login');
  }
}

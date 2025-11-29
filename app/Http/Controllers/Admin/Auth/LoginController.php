<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AdminLoginRequest;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
      return view('admin.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(AdminLoginRequest $request)
    {
      try {
        $request->authenticate(); // Ensure this method throws an exception if authentication fails
        $request->session()->regenerate(); // Regenerate only on successful authentication
        // Get admin user from admin guard
        $admin = Auth::guard('admin')->user();

        // Safely get operating country IDs
        //$countryIds = $admin?->operatingCountries()?->pluck('operating_country_id')->toArray() ?? [];


        //session(['country_ids' => $countryIds]);

        return redirect()->intended(route('dashboard.index', absolute: false));
      } catch (AuthenticationException $e) {
          // Handle the authentication failure
          return back()->withErrors(['error' => 'Invalid credentials.'.$e])->withInput();
      }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        return redirect(route('admin.login',absolute: false));
        //return response()->noContent();
    }
}

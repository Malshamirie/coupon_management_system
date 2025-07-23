<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\EmployeeLoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class EmployeeLoginController extends Controller
{
    /**
     * Display the login view.
     */
    public function employee_login()
    {
        return view('auth.employee_login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function employee_login_post(EmployeeLoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();
        return redirect()->intended(RouteServiceProvider::EMPLOYEE);
    }



    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('employee')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}

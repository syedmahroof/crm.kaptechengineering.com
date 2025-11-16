<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

final readonly class AuthenticatedSessionController
{
    /**
     * Show the login page.
     */
    public function create(Request $request): View
    {
        return view('auth.login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => $request->session()->get('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Get intended URL or default to dashboard
        $redirectTo = $request->session()->pull('url.intended', route('dashboard'));

        // When redirecting from Inertia login to Blade dashboard,
        // we need to ensure a full page redirect happens
        // Inertia will automatically do this when it receives a redirect to a non-Inertia route
        return redirect($redirectTo);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}

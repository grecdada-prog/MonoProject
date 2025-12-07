<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Traits\HandlesTwoFactor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperAdminLoginController extends Controller
{
    use HandlesTwoFactor;

    public function login(Request $request)
    {
        $request->validate([
            'identifier' => 'required',
            'password'   => 'required',
        ]);

        $identifier = $request->input('identifier');
        $field = filter_var($identifier, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (!Auth::attempt([$field => $identifier, 'password' => $request->password])) {
            return back()->withErrors(['identifier' => 'Identifiants incorrects']);
        }

        $user = auth()->user();

        if (!$user->hasRole('super-admin')) {
            Auth::logout();
            return back()->withErrors(['identifier' => 'Vous n’êtes pas Super Admin']);
        }

        if ($this->startTwoFactorFor($user)) {
            Auth::logout();
            return redirect()->route('twofactor.form');
        }

        // Si TOTP est activé
        if ($this->startTotpFor($user)) {
            Auth::logout();
            return redirect()->route('twofactor.form.totp');
        }

        return redirect()->route('superadmin.dashboard');
    }
}

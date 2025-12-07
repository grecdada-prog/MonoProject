<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Traits\HandlesTwoFactor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MixedLoginController extends Controller
{
    use HandlesTwoFactor;

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'role'     => 'required|in:gerant,vendeur',
        ]);

        if (!Auth::attempt($request->only('username', 'password'))) {
            return back()->withErrors(['username' => 'Identifiants incorrects']);
        }

        $user = auth()->user();

        if (!$user->hasRole($request->role)) {
            Auth::logout();
            return back()->withErrors(['username' => "Vous n'avez pas accès à ce rôle"]);
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

        if ($user->hasRole('gerant')) {
            return redirect()->route('gerant.dashboard');
        }

        if ($user->hasRole('vendeur')) {
            return redirect()->route('vendeur.dashboard');
        }

        Auth::logout();
        return back()->withErrors(['username' => 'Rôle non valide sur ce portail']);
    }
}

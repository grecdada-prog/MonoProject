<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OTPHP\TOTP;

class TotpChallengeController extends Controller
{
    public function showForm()
    {
        if (!session()->has('2fa:totp:user:id')) {
            return redirect()->route('login.mix');
        }

        return view('auth.two-factor-totp');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:6',
        ]);

        $userId = session('2fa:totp:user:id');
        if (!$userId) {
            return redirect()->route('login.mix');
        }

        $user = User::findOrFail($userId);

        if (!$user->totp_enabled || !$user->totp_secret) {
            return redirect()->route('login.mix')->withErrors([
                'code' => 'TOTP non activé pour cet utilisateur.',
            ]);
        }

        $totp = TOTP::create($user->totp_secret);

        if (!$totp->verify($request->code)) {
            return back()->withErrors([
                'code' => 'Code TOTP incorrect ou invalide.',
            ]);
        }

        // Validation réussie
        session()->forget('2fa:totp:user:id');

        Auth::login($user);

        return redirect()->route('redirect'); // redirection intelligente selon rôle
    }
}

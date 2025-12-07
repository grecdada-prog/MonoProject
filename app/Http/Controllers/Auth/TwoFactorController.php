<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\TwoFactorCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TwoFactorController extends Controller
{
    public function showForm()
    {
        if (!session()->has('2fa:user:id')) {
            return redirect()->route('login.mix');
        }

        return view('auth.two-factor');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:6',
        ]);

        $userId = session('2fa:user:id');

        if (!$userId) {
            return redirect()->route('login.mix');
        }

        $record = TwoFactorCode::where('user_id', $userId)
            ->where('used', false)
            ->where('expires_at', '>=', now())
            ->orderByDesc('id')
            ->first();

        if (!$record || !Hash::check($request->code, $record->code)) {
            return back()->withErrors(['code' => 'Code invalide ou expiré']);
        }

        $record->update(['used' => true]);

        $user = User::findOrFail($userId);
        Auth::login($user);

        session()->forget('2fa:user:id');

        return redirect()->route('redirect');
    }
}

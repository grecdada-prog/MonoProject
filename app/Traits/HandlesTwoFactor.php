<?php

namespace App\Traits;

use App\Models\TwoFactorCode;
use App\Notifications\TwoFactorCodeNotification;
use Illuminate\Support\Facades\Hash;

trait HandlesTwoFactor
{
    protected function startTwoFactorFor($user)
    {
        if (!$user->two_factor_enabled) {
            return false;
        }

        $code = random_int(100000, 999999);

        TwoFactorCode::create([
            'user_id'    => $user->id,
            'code'       => Hash::make($code),
            'expires_at' => now()->addMinutes(10),
        ]);

        $user->notify(new TwoFactorCodeNotification((string)$code));

        session(['2fa:user:id' => $user->id]);

        return true;
    }

    protected function startTotpFor($user)
    {
        if (!$user->totp_enabled) {
            return false;
        }

        session(['2fa:totp:user:id' => $user->id]);

        return true;
    }
}

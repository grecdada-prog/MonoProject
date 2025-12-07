<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OTPHP\TOTP;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class TotpController extends Controller
{
    public function setup()
    {
        $user = Auth::user();

        // générer un secret si inexistant
        if (!$user->totp_secret) {
            $user->totp_secret = TOTP::create()->getSecret();
            $user->save();
        }

        // générer QR code
        $totp = TOTP::create(
            secret: $user->totp_secret,
            issuer: 'SmartStock',
            label: $user->email
        );

        $uri = $totp->getProvisioningUri();

        $renderer = new ImageRenderer(
            new RendererStyle(300),
            new SvgImageBackEnd()
        );

        $writer = new Writer($renderer);
        $qrCodeSvg = $writer->writeString($uri);

        return view('auth.totp-setup', [
            'qr' => $qrCodeSvg,
            'secret' => $user->totp_secret,
        ]);
    }

    public function verify(Request $request)
    {
        $request->validate(['code' => 'required|digits:6']);

        $user = Auth::user();

        $totp = TOTP::create($user->totp_secret);

        if (!$totp->verify($request->code)) {
            return back()->withErrors(['code' => 'Code TOTP incorrect']);
        }

        $user->totp_enabled = true;
        $user->save();

        return redirect()->route('profile.edit')->with('success', 'TOTP activé avec succès.');
    }

    public function disable(Request $request)
    {
        $request->validate([
            'password' => 'required'
        ]);

        $user = Auth::user();

        // Vérification du mot de passe
        if (!\Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'Mot de passe incorrect.'
            ]);
        }

        $user->totp_enabled = false;
        $user->totp_secret = null;
        $user->save();

        return back()->with('success', 'TOTP désactivé.');
    }

}

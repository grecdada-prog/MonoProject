<?php

namespace App\Http\Controllers;

use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    use LogsActivity;

    public function edit()
    {
        return view('profile.edit', [
            'user' => Auth::user(),
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'     => 'required',
            'username' => 'required|unique:users,username,' . $user->id,
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'phone'    => 'nullable|string',
            'avatar'   => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048|dimensions:max_width=2000,max_height=2000',
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar_path) {
                Storage::disk('public')->delete($user->avatar_path);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar_path = $path;
        }

        $user->name     = $request->name;
        $user->username = $request->username;
        $user->email    = $request->email;
        $user->phone    = $request->phone;
        $user->save();

        $this->logActivity('PROFILE_UPDATED', $user, "Profil mis à jour par l'utilisateur.");
        $this->notifySuperAdmins('Profil utilisateur modifié', "L'utilisateur {$user->email} a modifié son profil.");

        if ($user->hasRole('vendeur') && $user->manager_id) {
            if ($user->manager) {
                $this->notifyUser(
                    $user->manager,
                    'Profil vendeur modifié',
                    "Le vendeur {$user->email} a modifié son profil."
                );
            }
        }

        return back()->with('success', 'Profil mis à jour.');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password'      => 'required',
            'new_password'          => ['required', 'confirmed', Password::defaults()],
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mot de passe actuel incorrect']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        // Log détaillé avec contexte (IP, user agent, rôle)
        $role = $user->roles->first()->name ?? 'aucun rôle';
        $ip = $request->ip();
        $userAgent = $request->userAgent();
        $details = "Mot de passe modifié | Utilisateur: {$user->email} | Rôle: {$role} | IP: {$ip} | User-Agent: " . substr($userAgent, 0, 100);

        $this->logActivity('PASSWORD_UPDATED', $user, $details);
        $this->notifySuperAdmins('Mot de passe modifié', $details);

        // Notifier le manager si l'utilisateur est un vendeur (avec contexte IP)
        if ($user->hasRole('vendeur') && $user->manager_id && $user->manager) {
            $this->notifyUser(
                $user->manager,
                'Mot de passe vendeur modifié',
                "Le vendeur {$user->email} a changé son mot de passe depuis l'IP: {$ip}"
            );
        }

        return back()->with('success', 'Mot de passe mis à jour.');
    }
}

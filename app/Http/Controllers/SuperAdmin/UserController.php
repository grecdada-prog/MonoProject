<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Store;
use App\Models\UserSession;
use App\Traits\LogsActivity;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use LogsActivity;

    public function index()
    {
        $users = User::with('roles', 'store')
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        return view('superadmin.users.index', compact('users'));
    }

    public function create()
    {
        $stores = Store::where('is_active', true)->orderBy('name')->get();

        return view('superadmin.users.create', compact('stores'));
    }

    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'name'     => $validated['name'],
            'username' => $validated['username'],
            'email'    => $validated['email'],
            'phone'    => $validated['phone'] ?? null,
            'store_id' => $validated['store_id'] ?? null,
            'password' => Hash::make($validated['password']),
        ]);

        $user->assignRole($validated['role']);

        $this->logActivity('USER_CREATED', $user, "Création de l'utilisateur {$user->email} avec le rôle {$validated['role']}");
        $this->notifyUser($user, 'Compte SmartStock créé', "Votre compte a été créé avec le rôle {$validated['role']}.");

        return redirect()->route('superadmin.users.index')
            ->with('success', 'Utilisateur créé avec succès.');
    }

    public function edit(User $user)
    {
        $stores = Store::where('is_active', true)->orderBy('name')->get();

        return view('superadmin.users.edit', compact('user', 'stores'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();

        $user->update([
            'name'     => $validated['name'],
            'username' => $validated['username'],
            'email'    => $validated['email'],
            'phone'    => $validated['phone'] ?? null,
            'store_id' => $validated['store_id'] ?? null,
        ]);

        if (isset($validated['role'])) {
            $user->syncRoles([$validated['role']]);
        }

        $this->logActivity('USER_UPDATED', $user, "Modification de l'utilisateur {$user->email}");
        $this->notifyUser($user, 'Compte SmartStock modifié', "Votre compte a été mis à jour par le Super Admin.");

        return redirect()->route('superadmin.users.index')
            ->with('success', 'Utilisateur mis à jour.');
    }

    public function toggleStatus(User $user)
    {
        $user->is_active = !$user->is_active;
        $user->save();

        $status = $user->is_active ? 'activé' : 'désactivé';

        $this->logActivity('USER_TOGGLED', $user, "Utilisateur {$user->email} {$status}");
        $this->notifyUser($user, 'Statut de votre compte', "Votre compte a été {$status} par le Super Admin.");

        return back()->with('success', 'Statut utilisateur modifié.');
    }

    public function destroy(User $user)
    {
        // Collecter informations avant suppression pour logging détaillé
        $email = $user->email;
        $role = $user->roles->first()->name ?? 'aucun rôle';
        $store = $user->store ? $user->store->name : 'aucun magasin';

        // Compter données associées (ventes, vendeurs gérés, etc.)
        $salesCount = 0;
        $managedUsersCount = 0;

        if ($user->hasRole('vendeur')) {
            $salesCount = \App\Models\Sale::where('seller_id', $user->id)->count();
        } elseif ($user->hasRole('gerant')) {
            $managedUsersCount = User::where('manager_id', $user->id)->count();
            $salesCount = \App\Models\Sale::where('manager_id', $user->id)->count();
        }

        $user->delete();

        // Log détaillé avec contexte complet
        $details = "Suppression utilisateur: {$email} | Rôle: {$role} | Magasin: {$store} | Ventes: {$salesCount}";
        if ($managedUsersCount > 0) {
            $details .= " | Vendeurs gérés: {$managedUsersCount}";
        }

        $this->logActivity('USER_DELETED', null, $details);
        $this->notifySuperAdmins('Utilisateur supprimé', $details);

        return back()->with('success', 'Utilisateur supprimé.');
    }

    public function forceLogout(User $user)
    {
        UserSession::where('user_id', $user->id)->update(['is_active' => false]);

        $this->logActivity('USER_FORCE_LOGOUT', $user, "Déconnexion forcée de {$user->email}");
        $this->notifyUser($user, 'Déconnexion forcée', "Votre session a été fermée par le Super Admin.");

        return back()->with('success', 'L’utilisateur a été déconnecté.');
    }
}

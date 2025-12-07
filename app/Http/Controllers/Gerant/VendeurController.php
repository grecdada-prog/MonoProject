<?php

namespace App\Http\Controllers\Gerant;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class VendeurController extends Controller
{
    use LogsActivity;

    public function index()
    {
        $manager = Auth::user();

        $vendeurs = User::role('vendeur')
            ->where('manager_id', $manager->id)
            ->with('sessions')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('gerant.vendeurs.index', compact('vendeurs'));
    }

    public function create()
    {
        return view('gerant.vendeurs.create');
    }

    public function store(Request $request)
    {
        $manager = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'phone' => 'nullable|string|max:255',
        ]);

        $vendeur = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'manager_id' => $manager->id,
            'store_id' => $manager->store_id, // Hériter du magasin du gérant
            'is_active' => true,
        ]);

        $vendeur->assignRole('vendeur');

        $this->logActivity('VENDEUR_CREATED', $vendeur, "Vendeur {$vendeur->email} créé par le gérant {$manager->email}");
        $this->notifySuperAdmins('Nouveau vendeur créé', "Le gérant {$manager->email} a créé le vendeur {$vendeur->email}");

        return redirect()->route('gerant.vendeurs.index')
            ->with('success', 'Vendeur créé avec succès');
    }

    public function edit(User $vendeur)
    {
        $manager = Auth::user();

        // Vérifier que le vendeur appartient au gérant
        if ($vendeur->manager_id !== $manager->id) {
            abort(403, 'Accès non autorisé');
        }

        return view('gerant.vendeurs.edit', compact('vendeur'));
    }

    public function update(Request $request, User $vendeur)
    {
        $manager = Auth::user();

        // Vérifier que le vendeur appartient au gérant
        if ($vendeur->manager_id !== $manager->id) {
            abort(403, 'Accès non autorisé');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $vendeur->id,
            'email' => 'required|email|unique:users,email,' . $vendeur->id,
            'phone' => 'nullable|string|max:255',
        ]);

        $vendeur->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        $this->logActivity('VENDEUR_UPDATED', $vendeur, "Vendeur {$vendeur->email} modifié par le gérant {$manager->email}");

        return redirect()->route('gerant.vendeurs.index')
            ->with('success', 'Vendeur modifié avec succès');
    }

    public function toggleStatus(User $vendeur)
    {
        $manager = Auth::user();

        // Vérifier que le vendeur appartient au gérant
        if ($vendeur->manager_id !== $manager->id) {
            abort(403, 'Accès non autorisé');
        }

        $vendeur->is_active = !$vendeur->is_active;
        $vendeur->save();

        $status = $vendeur->is_active ? 'activé' : 'désactivé';

        $this->logActivity('VENDEUR_STATUS_CHANGED', $vendeur, "Vendeur {$vendeur->email} {$status} par le gérant {$manager->email}");

        return back()->with('success', "Vendeur {$status} avec succès");
    }

    public function destroy(User $vendeur)
    {
        $manager = Auth::user();

        // Vérifier que le vendeur appartient au gérant
        if ($vendeur->manager_id !== $manager->id) {
            abort(403, 'Accès non autorisé');
        }

        $this->logActivity('VENDEUR_DELETED', $vendeur, "Vendeur {$vendeur->email} supprimé par le gérant {$manager->email}");
        $this->notifySuperAdmins('Vendeur supprimé', "Le gérant {$manager->email} a supprimé le vendeur {$vendeur->email}");

        $vendeur->delete();

        return redirect()->route('gerant.vendeurs.index')
            ->with('success', 'Vendeur supprimé avec succès');
    }
}

<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StoreController extends Controller
{
    /**
     * Liste tous les magasins/blocs
     */
    public function index()
    {
        $stores = Store::withCount(['managers', 'users'])
            ->with(['managers' => function($q) {
                $q->where('is_active', true);
            }])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('superadmin.stores.index', compact('stores'));
    }

    /**
     * Formulaire création magasin
     */
    public function create()
    {
        return view('superadmin.stores.create');
    }

    /**
     * Enregistrer nouveau magasin
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50|unique:stores,code',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
        ]);

        // Générer code automatiquement si non fourni
        if (empty($validated['code'])) {
            $validated['code'] = 'BLC' . str_pad(Store::count() + 1, 3, '0', STR_PAD_LEFT);
        }

        $store = Store::create($validated);

        return redirect()
            ->route('superadmin.stores.index')
            ->with('success', "Le magasin {$store->name} a été créé avec succès.");
    }

    /**
     * Afficher détails d'un magasin
     */
    public function show(Store $store)
    {
        $store->load(['managers', 'users']);

        // Stats du magasin
        $stats = $store->stats();

        return view('superadmin.stores.show', compact('store', 'stats'));
    }

    /**
     * Formulaire édition magasin
     */
    public function edit(Store $store)
    {
        return view('superadmin.stores.edit', compact('store'));
    }

    /**
     * Mettre à jour magasin
     */
    public function update(Request $request, Store $store)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:stores,code,' . $store->id,
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
            'is_active' => 'nullable|boolean',
        ]);

        $store->update($validated);

        return redirect()
            ->route('superadmin.stores.index')
            ->with('success', "Le magasin {$store->name} a été mis à jour.");
    }

    /**
     * Basculer statut actif/inactif
     */
    public function toggleStatus(Store $store)
    {
        $store->update(['is_active' => !$store->is_active]);

        $status = $store->is_active ? 'activé' : 'désactivé';

        return redirect()
            ->back()
            ->with('success', "Le magasin {$store->name} a été {$status}.");
    }

    /**
     * Supprimer magasin
     */
    public function destroy(Store $store)
    {
        // Vérifier si le magasin a des utilisateurs
        if ($store->users()->count() > 0) {
            return redirect()
                ->back()
                ->with('error', "Impossible de supprimer ce magasin car il contient des utilisateurs.");
        }

        $name = $store->name;
        $store->delete();

        return redirect()
            ->route('superadmin.stores.index')
            ->with('success', "Le magasin {$name} a été supprimé.");
    }
}

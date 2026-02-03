<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pret;

class PretController extends Controller
{
    // Afficher la liste
    public function index(Request $request) {
        $search = $request->input('search');

        $prets = Pret::where('est_rendu', false)
            ->when($search, function ($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('employe', 'LIKE', "%{$search}%")
                    ->orWhere('accessoire', 'LIKE', "%{$search}%")
                    ->orWhere('numero_serie', 'LIKE', "%{$search}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->get();

    return view('prets', compact('prets'));
    }

    // Enregistrer un prêt
    public function store(Request $request) {
        //dd($request->all());
        if (!auth()->check()) {
        return back()->with('error', "Vous devez être connecté !");
    }
        $request->validate([
            'employe' => 'required',
            'accessoire' => 'required',
            'numero_serie' => 'nullable',
        ]);
    // On crée le prêt en ajoutant la date actuelle manuellement
        Pret::create([
            'employe' => $request->employe,
            'site' => $request->site,
            'accessoire' => $request->accessoire,
            'numero_serie' => $request->numero_serie,
            'technicien' => auth()->user()->name,
            'date_affectation' => now(),
        ]);
        return back()->with('success', 'Prêt enregistré !');
    }
    

    // Marquer comme rendu
    public function update($id) {
        $pret = Pret::findOrFail($id);
        $pret->update(['est_rendu' => true]);
        return back()->with('success', 'Le matériel a été marqué comme rendu et retiré de la liste.');
    }

    //l'historique 
    public function historique() {
        $historique = Pret::where('est_rendu', true)
                                  ->orderBy('updated_at', 'desc')
                                  ->paginate(15); // Utilise la pagination si tu as beaucoup de données

        return view('historique', compact('historique'));
    }

    public function destroy($id)
        {
            $pret = \App\Models\Pret::findOrFail($id);
            $pret->delete();

            return back()->with('success', "L'enregistrement a été supprimé.");
        }
    
}

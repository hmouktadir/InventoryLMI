<?php

namespace App\Http\Controllers;

use App\Models\SalleEquipement;
use Illuminate\Http\Request;
use App\Exports\SallesExport;
use Maatwebsite\Excel\Facades\Excel;


class SalleController extends Controller {
    public function index() {
        $equipements = \App\Models\SalleEquipement::orderBy('nom_salle')->get();
        // On récupère uniquement les articles qui ont du stock
        $articlesDisponibles = \App\Models\Stock::where('quantite', '>', 0)->get();
        
        return view('salles', compact('equipements', 'articlesDisponibles'));
    }

    public function store(Request $request) 
    {
            // 1. Validation stricte
        $request->validate([
            'nom_salle' => 'required|string|max:255',
            'site'      => 'required|string', // Ajout du site
            'materiel'  => 'required|string',
            'etat'      => 'required|string',
        ]);

        // Utilisation d'une transaction pour la sécurité des données
        return \DB::transaction(function () use ($request) {
            try {
                // 2. On cherche l'article en stock
                $articleStock = \App\Models\Stock::where('designation', $request->materiel)->first();

                if (!$articleStock || $articleStock->quantite <= 0) {
                    return back()->with('error', "Stock insuffisant pour : " . $request->materiel);
                }

                // 3. Création de l'affectation
                \App\Models\SalleEquipement::create([
                    'nom_salle'  => $request->nom_salle,
                    'site'       => $request->site, // Ajouté
                    'materiel'   => $request->materiel,
                    'etat'       => $request->etat,
                    'technicien' => auth()->user()->name,
                ]);

                // 4. Décrémentation atomique
                $articleStock->decrement('quantite', 1);

                return redirect()->back()->with('success', 'Matériel affecté avec succès par ' . auth()->user()->name);

            } catch (\Exception $e) {
                return back()->with('error', "Erreur technique : " . $e->getMessage());
            }
        });
        
    }
    
    public function destroy($id) {
        SalleEquipement::findOrFail($id)->delete();
        return back()->with('success', 'Équipement retiré avec succès');
    }

    public function update(Request $request, $id)
    {
        $salle = \App\Models\SalleEquipement::findOrFail($id);
        $salle->update([
            'materiel_affecte' => $request->materiel_affecte
        ]);
        return back()->with('success', 'Mise à jour réussie !');
    }

    // pour exporter le tableau au format excel
    public function exportExcel() 
    {
        return Excel::download(new SallesExport, 'inventaire-salles-' . now()->format('d-m-Y') . '.xlsx');
    }
}
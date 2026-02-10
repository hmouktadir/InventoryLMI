<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\StockHistory;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::orderBy('categorie')->get();
        return view('stock', compact('stocks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'designation' => 'required|string|max:255',
            'categorie' => 'required|string',
            'quantite' => 'required|integer|min:0',
            'seuil_alerte' => 'required|integer|min:0',
        ]);

        Stock::create($request->all());

        return back()->with('success', 'Article ajouté au stock avec succès !');
    }

    // Optionnel : Pour mettre à jour rapidement la quantité
    public function update(Request $request, $id)
    {
        // 1. On récupère l'article
        $stock = \App\Models\Stock::findOrFail($id);
        $ancienneQuantite = $stock->quantite;

        // 2. Validation (on accepte les nombres négatifs pour les retraits)
        $request->validate([
            'quantite' => 'required|integer', // On enlève min:0 pour permettre les -5, -10
        ]);

        $ajustement = (int)$request->quantite;
        $nouvelleQuantite = $ancienneQuantite + $ajustement;

        // Sécurité : Empêcher un stock négatif
        if ($nouvelleQuantite < 0) {
            return back()->with('error', 'Action impossible : le stock tomberait à ' . $nouvelleQuantite);
        }

        // 3. Mise à jour réelle
        $stock->update([
            'quantite' => $nouvelleQuantite
        ]);

        // 4. Historique détaillé
        StockHistory::create([
            'stock_id' => $stock->id,
            'designation' => $stock->designation,
            'ancienne_quantite' => $ancienneQuantite,
            'nouvelle_quantite' => $nouvelleQuantite,
            'type_mouvement' => $ajustement > 0 ? 'Réapprovisionnement (+)' : 'Retrait (-)',
            'technicien' => auth()->user()->name,
        ]);

        return back()->with('success', "Mouvement de $ajustement unité(s) enregistré !");
    }

    public function destroy($id)
    {
        $stock = Stock::findOrFail($id);
        $stock->delete();
        return back()->with('success', 'Article supprimé du stock.');
    }

    public function history()
    {
        // On récupère tout l'historique trié du plus récent au plus ancien
        $historiques = StockHistory::latest()->get();
        
        return view('historique_stock', compact('historiques'));
    }

    public function edit($id)
    {
        $stock = Stock::findOrFail($id);
        return view('stock_edit', compact('stock'));
    }

        public function show($id)
    {
        // Au lieu de planter, on redirige vers la liste
        return redirect()->route('stock.index');
    }
}
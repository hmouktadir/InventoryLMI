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
            // 1. On récupère l'article avant modification
        $stock = \App\Models\Stock::findOrFail($id);
        $ancienneQuantite = $stock->quantite;

        // 2. Validation
        $request->validate([
            'quantite' => 'required|integer|min:0',
        ]);

        // 3. Mise à jour
        $stock->update([
            'quantite' => $request->quantite
        ]);

        // 4. Historique
        StockHistory::create([
            'stock_id' => $stock->id,
            'designation' => $stock->designation,
            'ancienne_quantite' => $ancienneQuantite,
            'nouvelle_quantite' => $request->quantite,
            'type_mouvement' => 'Mise à jour manuelle',
            'technicien' => auth()->user()->name,
        ]);

        return back()->with('success', 'Stock mis à jour avec succès !');
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
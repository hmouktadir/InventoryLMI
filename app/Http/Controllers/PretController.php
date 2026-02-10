<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pret;
use Barryvdh\DomPDF\Facade\Pdf;

class PretController extends Controller
{
    // Afficher la liste
    public function index(Request $request) {
        $search = $request->input('search');

        // 1. On récupère les prêts en cours (non rendus) avec le filtrage
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

        // 2. ON AJOUTE CECI : Récupérer les articles en stock pour le formulaire
        // On ne prend que ceux qui ont une quantité > 0 pour éviter de prêter du vide
        $stocks = \App\Models\Stock::where('quantite', '>', 0)
            ->orderBy('designation', 'asc')
            ->get();

        // 3. On passe les deux variables à la vue
        return view('prets', compact('prets', 'stocks'));
    }

    // Enregistrer un prêt
    public function store(Request $request) {
        //dd($request->all());
        if (!auth()->check()) {
            return back()->with('error', "Vous devez être connecté !");
        }

        $request->validate([
            'employe' => 'required',
            'stock_id' => 'required|exists:stocks,id', // On valide l'ID du stock sélectionné
            'numero_serie' => 'nullable',
        ]);

        // 1. On récupère l'article en stock
        $stock = \App\Models\Stock::find($request->stock_id);

        // 2. Vérification de la disponibilité
        if (!$stock || $stock->quantite <= 0) {
            return back()->with('error', "L'accessoire " . ($stock->designation ?? '') . " n'est plus disponible en stock !");
        }

        // 3. Création du Prêt
        Pret::create([
            'employe' => $request->employe,
            'site' => $request->site,
            'stock_id' => $stock->id, // Liaison ID
            'accessoire' => $stock->designation,
            'numero_serie' => $request->numero_serie,
            'technicien' => auth()->user()->name,
            'date_affectation' => now(),
        ]);

        // 4. Déduction automatique du Stock
        $stock->decrement('quantite', 1); // Retire 1 du stock

        // 5. Log d'Audit
        \App\Models\ActivityLog::create([
            'admin_id' => auth()->id(),
            'action' => 'Prêt matériel',
            'target_user' => $request->employe,
            'details' => "A prêté 1x {$stock->designation}. Stock restant : {$stock->quantite}"
        ]);

        return back()->with('success', 'Prêt enregistré et stock mis à jour !');
    }
    

    // Marquer comme rendu
    public function update($id) {
        $pret = Pret::findOrFail($id);

        // Sécurité : On ne traite le retour que si l'objet n'est pas déjà marqué comme rendu
        if (!$pret->est_rendu) {
            
            // 1. On cherche l'article dans le stock via le stock_id
            $stock = \App\Models\Stock::find($pret->stock_id);

            if ($stock) {
                // 2. On réinjecte 1 unité dans le stock
                $stock->increment('quantite', 1);
            }

            // 3. On marque le prêt comme rendu
            $pret->update([
                'est_rendu' => true,
            ]);

            // 4. Log d'Audit pour l'historique
            \App\Models\ActivityLog::create([
                'admin_id' => auth()->id(),
                'action' => 'Retour matériel',
                'target_user' => $pret->employe,
                'details' => "A rendu : {$pret->accessoire}. Stock réapprovisionné."
            ]);

            return back()->with('success', "Matériel rendu ! Le stock de {$pret->accessoire} a été mis à jour (+1).");
        }

        return back()->with('error', "Ce prêt a déjà été traité.");
    }

    //l'historique 
    public function historique() {
        $historique = Pret::where('est_rendu', true)
                                  ->orderBy('updated_at', 'desc')
                                  ->paginate(20);

        return view('historique', compact('historique'));
    }

    public function destroy($id)
    {
        $pret = \App\Models\Pret::findOrFail($id);
        $pret->delete();

        return back()->with('success', "L'enregistrement a été supprimé.");
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }


    // Génération du PDF de décharge
    public function genererPDF($id)
    {
        $pret = Pret::with('stock')->findOrFail($id);

        $pdf = Pdf::loadView('pdf.decharge', compact('pret'));
        
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOption([
            'isRemoteEnabled' => true,
            'isHtml5ParserEnabled' => true,
            'margin_top' => 0,
            'margin_bottom' => 0,
            'margin_left' => 0,
            'margin_right' => 0,
        ]);

        // .stream() ouvre dans le navigateur
        return $pdf->stream("Bon_Decharge_{$pret->employe}.pdf");
    }
    
}

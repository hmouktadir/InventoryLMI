<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pret; // <--- AJOUTE CETTE LIGNE
use App\Models\Stock; // Si tu as un modèle Stock, ajoute-le aussi



class DashboardController extends Controller
{
    public function index()
    {
        // 1. Compter les prêts actifs
        $pretsCount = Pret::where('est_rendu', '0')->count();

        // 2. Compter les articles en stock critique (ex: moins de 3 unités)
        // Si tu n'as pas encore de table stock, tu peux mettre 0 pour l'instant
        
        $lowStockCount = Stock::where('quantite', '<=', 3)->count();

        // Récupère le nombre de prêts par site
        $repartition = Pret::select('site', \DB::raw('count(*) as total'))
            ->groupBy('site')
            ->pluck('total', 'site')
            ->all();

        // On récupère les articles en rupture ou presque
        $articlesCritiques = Stock::where('quantite', '<=', 3)
                                ->orderBy('quantite', 'asc')
                                ->get();

        $lowStockCount = $articlesCritiques->count();

        // On s'assure que tous les sites sont présents, même avec 0
        $sites = ['Lycée', 'Collège', 'B1', 'B2'];
        $dataGraph = [];
        foreach($sites as $site) {
            $dataGraph[] = $repartition[$site] ?? 0;
        }
        
        return view('dashboard', compact('pretsCount', 'lowStockCount', 'articlesCritiques', 'dataGraph'));
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pret extends Model
{
    protected $fillable = ['employe', 'stock_id', 'accessoire', 'numero_serie', 'technicien', 'date_affectation', 'est_rendu', 'site'];

    /**
     * Définit la relation entre un Prêt et un article du Stock
     */
    public function stock(): BelongsTo
    {
        // On indique que le champ 'stock_id' de la table prets 
        // pointe vers l'id de la table stocks
        return $this->belongsTo(Stock::class, 'stock_id');
    }
}
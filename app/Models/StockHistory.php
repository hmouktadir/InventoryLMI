<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockHistory extends Model
{
    protected $fillable = [
        'stock_id',
        'designation',
        'ancienne_quantite',
        'nouvelle_quantite',
        'type_mouvement',
        'technicien',
    ];

    // Petit bonus : La relation pour retrouver l'article parent facilement
    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
}

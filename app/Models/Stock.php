<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = [
        'designation',
        'categorie',
        'quantite',
        'seuil_alerte',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pret extends Model
{
    protected $fillable = ['employe', 'accessoire', 'numero_serie', 'technicien', 'date_affectation', 'est_rendu', 'site'];
}

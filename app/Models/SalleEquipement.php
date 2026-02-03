<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalleEquipement extends Model
{
    protected $fillable = [
        'nom_salle',
        'materiel',
        'numero_serie',
        'etat',
        'technicien'];
}

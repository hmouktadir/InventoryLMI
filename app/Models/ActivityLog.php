<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = ['admin_id', 'action', 'target_user', 'details'];

    // Relation pour récupérer facilement le nom de l'admin dans la vue
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eleve extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom', 'prenom', 'email', 'password', 'classe_id', 'parent_id'
    ];

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    public function parent()
    {
        return $this->belongsTo(ParentModel::class);
    }
    public function presences()
    {
        return $this->hasMany(Presence::class, 'eleve_id');
    }
}


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    use HasFactory;

    // Spécifiez le nom de la table si différent du nom du modèle
    protected $table = 'presences';

    // Les attributs qui peuvent être assignés en masse
    protected $fillable = [
        'seance_id',
        'eleve_id',
        'status',
    ];

    // La liste des attributs qui doivent être castés en types spécifiques
    protected $casts = [
        'status' => 'string',
    ];

    // Définir les relations avec les autres modèles

    public function eleve()
    {
        return $this->belongsTo(Eleve::class, 'eleve_id');
    }

    public function seance()
    {
        return $this->belongsTo(Seance::class, 'seance_id');
    }
}

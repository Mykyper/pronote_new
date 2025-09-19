<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    use HasFactory;

    protected $fillable = [
        'niveau', 'specialité'
    ];

    public function eleves()
    {
        return $this->hasMany(Eleve::class);
    }

    public function seances()
    {
        return $this->hasMany(Seance::class, 'class_id');
    }
    protected $table = "classes";
}


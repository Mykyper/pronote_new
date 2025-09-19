<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom', 'prenom', 'email', 'password'
    ];

    public function eleves()
    {
        return $this->hasMany(Eleve::class, 'parent_id');
    }
    protected $table = 'parents';
}


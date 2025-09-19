<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'nom', 'prenom', 'email', 'password', 'role'
    ];

    public function seances()
    {
        return $this->hasMany(Seance::class, 'enseignant_id');
    }
    protected $table = "users";
}


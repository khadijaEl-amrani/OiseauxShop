<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ville extends Model
{
    use HasFactory;

    protected $fillable = ['ville'];

    public function users()
    {
        return $this->hasMany(User::class, 'id_ville');
    }

    public function annonces()
    {
        return $this->hasMany(Annonce::class, 'ville_id');
    }
}
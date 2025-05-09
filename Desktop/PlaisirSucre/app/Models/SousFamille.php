<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SousFamille extends Model
{
    /** @use HasFactory<\Database\Factories\SousFamilleFactory> */
    use HasFactory;

    public function famille(){
        return $this->belongsTo(Famille::class);
    }

    public function produits(){
        return $this->hasMany(Produit::class);
    }
}

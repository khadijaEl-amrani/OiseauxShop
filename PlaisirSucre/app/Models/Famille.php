<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Famille extends Model
{
    /** @use HasFactory<\Database\Factories\FamilleFactory> */
    use HasFactory;


    public function sousFamilles(){
        return $this->hasMany(SousFamille::class);
    }
}

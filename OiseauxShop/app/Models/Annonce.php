<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Annonce extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'description',
        'prix',
        'user_id',
        'categorie_id',
        'ville_id',
        'expérer',
        'valider',
    ];

    protected $casts = [
        'expérer' => 'boolean',
        'valider' => 'boolean',
        'prix' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'categorie_id');
    }

    public function ville()
    {
        return $this->belongsTo(Ville::class, 'ville_id');
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'annonce_id');
    }

    public function favoris()
    {
        return $this->hasMany(Favori::class, 'annonce_id');
    }

    public function usersFavoris()
    {
        return $this->belongsToMany(User::class, 'favoris', 'annonce_id', 'user_id');
    }
}
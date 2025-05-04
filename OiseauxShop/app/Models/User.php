<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'mot_de_passe',
        'tele',
        'id_ville',
        'adresse',
        'is_admin',
        'blockes',
    ];

    protected $hidden = [
        'mot_de_passe',
        'remember_token',
    ];

    protected $casts = [
        'is_admin' => 'boolean',
        'blockes' => 'boolean',
        'email_verified_at' => 'datetime',
    ];

    public function ville()
    {
        return $this->belongsTo(Ville::class, 'id_ville');
    }

    public function annonces()
    {
        return $this->hasMany(Annonce::class, 'user_id');
    }

    public function favoris()
    {
        return $this->hasMany(Favori::class, 'user_id');
    }

    public function annoncesFavorites()
    {
        return $this->belongsToMany(Annonce::class, 'favoris', 'user_id', 'annonce_id');
    }
}
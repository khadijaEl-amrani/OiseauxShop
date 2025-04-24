<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;

    protected $fillable = ['designation', 'description', 'prix', 'image', 'user_id', 'sous_famille_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commentaires()
    {
        return $this->hasMany(Commentaire::class);
    }

    public function detailsCommandes()
    {
        return $this->hasMany(DetailsCommande::class);
    }

    public function sousFamille(){
        return $this->belongsTo(SousFamille::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    protected $fillable = ['commande_date', 'client_id'];

    protected $casts = [
        'commande_date'=> 'datetime'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function detailsCommandes()
    {
        return $this->hasMany(DetailsCommande::class);
    }
}

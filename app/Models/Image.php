<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['chemin_image', 'annonce_id'];

    public function annonce()
    {
        return $this->belongsTo(Annonce::class, 'annonce_id');
    }
}
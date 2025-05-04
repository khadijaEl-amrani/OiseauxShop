<?php

namespace Database\Seeders;

use App\Models\Categorie;
use Illuminate\Database\Seeder;

class CategorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Perroquets',
            'Canaris',
            'Perruches',
            'Inséparables',
            'Colombes',
            'Oiseaux exotiques',
            'Poules et coqs',
            'Cailles',
            'Faisans',
            'Autres oiseaux',
        ];
        
        foreach ($categories as $categorie) {
            Categorie::create(['categorie' => $categorie]);
        }
    }
}
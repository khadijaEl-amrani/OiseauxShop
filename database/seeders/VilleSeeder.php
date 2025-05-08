<?php

namespace Database\Seeders;

use App\Models\Ville;
use Illuminate\Database\Seeder;

class VilleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $villes = [
            'fes',
            'rabat',
            'tanger',
            'marakech',
            'meknas',
            'cazablanca',
            'taza',
            'knitra'
        ];
        
        foreach ($villes as $ville) {
            Ville::create(['ville' => $ville]);
        }
    }
}
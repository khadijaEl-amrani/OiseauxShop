<?php

namespace Database\Seeders;

use App\Models\Famille;
use App\Models\SousFamille;
use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\Produit;
use App\Models\Commande;
use App\Models\DetailsCommande;
use App\Models\Commentaire;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory(20)->create();
        Client::factory(20)->create();
        Commande::factory(20)->create();
        Famille::factory(20)->create();
        SousFamille::factory(20)->create();
        Produit::factory(20)->create();
        Commentaire::factory(20)->create();
        DetailsCommande::factory(20)->create();
    }
}

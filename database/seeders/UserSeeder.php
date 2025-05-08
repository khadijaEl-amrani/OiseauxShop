<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'nom' => 'Admin',
            'prenom' => 'Super',
            'email' => 'admin@example.com',
            'mot_de_passe' => Hash::make('password'),
            'tele' => '0123456789',
            'id_ville' => 1, // Paris
            'adresse' => '123 Rue de Paris',
            'is_admin' => true,
            'blockes' => false,
        ]);
        
        // Create regular users
        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'nom' => 'Utilisateur' . $i,
                'prenom' => 'Prénom' . $i,
                'email' => 'user' . $i . '@example.com',
                'mot_de_passe' => Hash::make('password'),
                'tele' => '01234' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'id_ville' => rand(1, 10),
                'adresse' => $i . ' Rue des Oiseaux',
                'is_admin' => false,
                'blockes' => false,
            ]);
        }
    }
}
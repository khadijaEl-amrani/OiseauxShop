<?php

namespace Database\Seeders;

use App\Models\Annonce;
use App\Models\Image;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class AnnonceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $titres = [
            'Magnifique Perroquet Gris du Gabon',
            'Canari Jaune Chanteur',
            'Couple de Perruches Ondulées',
            'Inséparables Roseicollis',
            'Colombes Diamant',
            'Perroquet Amazone à Front Bleu',
            'Canaris Rouges Reproducteurs',
            'Perruche Calopsitte Apprivoisée',
            'Couple d\'Inséparables Fischer',
            'Tourterelles Blanches',
            'Perroquet Ara Ararauna',
            'Canaris de Posture',
            'Perruches à Collier',
            'Inséparables Masqués',
            'Colombes Turques',
        ];
        
        $descriptions = [
            'Magnifique perroquet gris du Gabon âgé de 3 ans. Très sociable et déjà bien parlant. Vendu avec sa cage et ses accessoires.',
            'Canari mâle jaune avec un chant mélodieux. Âgé de 1 an et en parfaite santé.',
            'Couple de perruches ondulées prêtes pour la reproduction. Baguées et en excellente santé.',
            'Couple d\'inséparables roseicollis âgés de 8 mois. Très colorés et pleins de vie.',
            'Paire de colombes diamant. Oiseaux calmes et faciles à élever.',
            'Superbe amazone à front bleu de 5 ans. Parle déjà plusieurs mots et très affectueux.',
            'Trio de canaris rouges (1 mâle, 2 femelles) pour reproduction. Excellente lignée.',
            'Perruche calopsitte grise apprivoisée. Monte sur le doigt et très sociable.',
            'Couple d\'inséparables Fischer prêts à se reproduire. Bonne génétique.',
            'Paire de tourterelles blanches idéales pour lâcher lors de cérémonies.',
            'Magnifique ara ararauna de 2 ans. Commence à parler et très joueur.',
            'Canaris de posture type Gloster. Excellents sujets pour exposition.',
            'Perruches à collier vertes. Jeunes et en bonne santé.',
            'Couple d\'inséparables masqués. Couleurs vives et oiseaux vigoureux.',
            'Colombes turques apprivoisées. Idéales comme premiers oiseaux.',
        ];
        
        for ($i = 0; $i < 15; $i++) {
            $annonce = Annonce::create([
                'titre' => $titres[$i],
                'description' => $descriptions[$i],
                'prix' => rand(50, 1500),
                'user_id' => rand(1, 10), // Random user
                'categorie_id' => rand(1, 10), // Random category
                'ville_id' => rand(1, 10), // Random city
                'expérer' => false,
                'valider' => rand(0, 1), // Some approved, some pending
                'created_at' => now()->subDays(rand(1, 30)), // Random date in the last month
            ]);
            
            // Add dummy images
            for ($j = 0; $j < rand(1, 3); $j++) {
                Image::create([
                    'chemin_image' => 'annonces/dummy-bird-' . rand(1, 5) . '.jpg',
                    'annonce_id' => $annonce->id,
                ]);
            }
        }
    }
}
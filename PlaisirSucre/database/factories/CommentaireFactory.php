<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CommentaireFactory extends Factory
{
    public function definition(): array
    {
        return [
            'contenu' => $this->faker->sentence,
            'commentaire_date' => now(),
            'produit_id' => 1,
            'client_id' => 1,
        ];
    }
}

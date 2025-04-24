<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DetailsCommandeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'commande_id' => 1,
            'produit_id' => 1,
            'quantité' => $this->faker->randomFloat(2, 1, 10),
        ];
    }
}

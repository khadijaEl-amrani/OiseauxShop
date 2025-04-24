<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProduitFactory extends Factory
{
    public function definition(): array
    {
        return [
            'designation' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'prix' => $this->faker->randomFloat(2, 10, 1000),
            'image' => $this->faker->imageUrl(640, 480, 'products', true),
            'user_id' => 1,
            'sous_famille_id' => 1,
        ];
    }
}

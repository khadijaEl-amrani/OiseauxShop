<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CommandeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'commande_date' => now(),
            'client_id' => 1,
        ];
    }
}

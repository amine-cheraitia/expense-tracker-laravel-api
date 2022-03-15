<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MouvementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'description' => $this->faker->text(50),
            'montant' => $this->faker->numberBetween(1000, 30000),
            'date_mouvement' => $this->faker->unique()->dateTimeBetween('now', '+15 days'),
            'solde_intermediaire' => $this->faker->numberBetween(10000, 50000),
            'user_id' => 1,
            'ressource_id' => $this->faker->numberBetween(1, 3),
            'type_mouvement_id' => $this->faker->numberBetween(1, 3),
        ];
    }
}
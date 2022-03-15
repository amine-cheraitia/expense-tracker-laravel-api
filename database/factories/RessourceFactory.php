<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RessourceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'num_compte' => $this->faker->randomNumber(5, true),
            'nom_ressource' => $this->faker->text(50),
            'solde' => $this->faker->numberBetween(33000, 100000),
            'type_ressources_id' => $this->faker->numberBetween(1, 3),
            'user_id' => $this->faker->numberBetween(1, 2)
        ];
    }
}
<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class Type_MouvementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'description' => $this->faker->name()
        ];
    }
}
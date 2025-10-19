<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'rating' => $this->faker->numberBetween(3, 5), // rating realistis
            'comment' => $this->faker->sentence(12), // komentar pendek
        ];
    }
}


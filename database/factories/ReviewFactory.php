<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    public function definition(): array
    {
        return [
            'product_id' => Product::inRandomOrder()->first()?->id ?? Product::factory(),
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'name' => $this->faker->name(),
            'rating' => $this->faker->numberBetween(1, 5),
            'comment' => $this->faker->sentence(10), 
        ];
    }
}

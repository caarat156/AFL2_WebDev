<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    public function definition(): array
    {
        return [
            'product_id' => Product::inRandomOrder()->first()?->id, // bisa null kalau belum ada product
            'name' => $this->faker->name(),
            'rating' => $this->faker->numberBetween(1, 5),
            'comment' => $this->faker->sentence(10),
        ];
    }
}

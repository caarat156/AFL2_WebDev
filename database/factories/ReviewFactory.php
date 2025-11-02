<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    public function definition(): array
    {
        return [
            'product_id' => Product::inRandomOrder()->first()?->id, // ambil 1 row acak di product buat di review, trs klo hasil firstnya ada maka ambil idnya tp klo ga ada hasil firstnya maka null
            'name' => $this->faker->name(),
            'rating' => $this->faker->numberBetween(1, 5),
            'comment' => $this->faker->sentence(10), // di view ga selalu 10 supaya terlihat rill no fek fek
        ];
    }
}

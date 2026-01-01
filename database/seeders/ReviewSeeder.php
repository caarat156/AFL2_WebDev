<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();
        $users = User::all();

        if ($products->isEmpty() || $users->isEmpty()) {
            return; // Skip if no products or users
        }

        foreach ($products as $product) {
            Review::factory()
                ->count(rand(2, 5))
                ->create([
                    'product_id' => $product->id,
                    'user_id' => $users->random()->id,
                ]);
        }
    }
}

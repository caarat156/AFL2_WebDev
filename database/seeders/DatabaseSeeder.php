<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ProductSeeder::class,
            StoreSeeder::class,
        ]);

        Review::factory(100)->create();
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
{
    $this->call([
        StoreSeeder::class,
    ]);
    
    $this->call([
        ProductSeeder::class,
        StoreSeeder::class,
    ]);

    \App\Models\Review::factory(100)->create();
    
}

}

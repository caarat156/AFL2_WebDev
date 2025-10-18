<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StoreSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('stores')->insert([
            [
                'name' => 'Canvas Living',
                'location' => 'PIM',
                'image' => 'welcome2.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Canvas Living',
                'location' => 'PS',
                'image' => 'welcome2.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mata Lokal',
                'location' => 'Jakarta',
                'image' => 'welcome2.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mata Lokal',
                'location' => 'Solo',
                'image' => 'welcome2.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mata Lokal',
                'location' => 'Bali',
                'image' => 'welcome2.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kalingga Art & Home Living',
                'location' => 'Jakarta',
                'image' => 'welcome2.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

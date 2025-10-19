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
                'image' => 'canvasliving_pim.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Canvas Living',
                'location' => 'PS',
                'image' => 'canvasliving_ps.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mata Lokal',
                'location' => 'Jakarta',
                'image' => 'matalokal_jkt.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mata Lokal',
                'location' => 'Solo',
                'image' => 'matalokal_solo.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mata Lokal',
                'location' => 'Bali',
                'image' => 'matalokal_bali.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kalingga Art & Home Living',
                'location' => 'Jakarta',
                'image' => 'kalingga.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

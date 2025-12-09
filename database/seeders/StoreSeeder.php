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
                'location' => 'Pondok Indah Mall, Jakarta',
                'image' => 'canvasliving_pim.jpg',
                'linkgmap' => 'https://share.google/gHDrInC6BHH0n7RC1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Canvas Living',
                'location' => 'Plaza Senayan, Jakarta',
                'image' => 'canvasliving_ps.jpg',
                'linkgmap' => 'https://share.google/45kbOKJd6arsM0PE9',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mata Lokal',
                'location' => 'M Bloc Space, Jakarta',
                'image' => 'matalokal_jkt.jpg',
                'linkgmap' => 'https://share.google/gmchtq0yRoS49tL9S',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mata Lokal',
                'location' => 'Lokananta, Solo',
                'image' => 'matalokal_solo.jpg',
                'linkgmap' => 'https://share.google/CHf8ocYSJn01IXJp1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mata Lokal',
                'location' => 'Seminyak, Bali',
                'image' => 'matalokal_bali.jpg',
                'linkgmap' => 'https://share.google/vROBoOLj0qSLI1xuG',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kalingga Art & Home Living',
                'location' => 'Jakarta',
                'image' => 'kalingga.jpg',
                'linkgmap' => 'https://share.google/RI0oN0d3vRBJnxD6f',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

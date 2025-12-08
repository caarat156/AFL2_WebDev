<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class WorkshopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('workshops')->insert([
            [
                'title' => 'Workshop Meracik Parfum Artisan',
                'description' => 'Belajar membuat parfum handmade menggunakan essential oil premium dan memahami struktur aroma top, middle, dan base notes.',
                'price' => 250000,
                'date' => '2025-12-21',
                'time' => '10:00:00',
                'location' => 'Jakarta',
                'capacity' => 20,
                'image' => 'images/artisan_perfume.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Kelas Membuat Scented Candle Aromatherapy',
                'description' => 'Pelajari teknik membuat lilin aromaterapi dengan soy wax, fragrance oil, pewarna natural, dan proses curing.',
                'price' => 180000,
                'date' => '2025-12-23',
                'time' => '13:30:00',
                'location' => 'Bandung',
                'capacity' => 15,
                'image' => 'images/scented_candle1.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Advanced Perfume Blending: Signature Scent',
                'description' => 'Kelas lanjutan untuk meracik parfum signature dengan mempelajari fixative, projection, dan teknik layering aroma profesional.',
                'price' => 350000,
                'date' => '2026-01-10',
                'time' => '09:00:00',
                'location' => 'Surabaya',
                'capacity' => 25,
                'image' => 'images/signature_perfume.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}

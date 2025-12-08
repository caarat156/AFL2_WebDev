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
            UserSeeder::class,
            WorkshopSeeder::class,
        ]);

        Review::factory(100)->create();
        //$product->reviews()->create(); //cara lain membuat review pakai relasi dari product, ini dipake buat membuat review spesifik utk product tertentu dan biasanya untuk real data
    }
}

// Seeder ini akan menjalankan ProductSeeder dan StoreSeeder untuk mengisi tabel produk dan toko,
// serta menggunakan Review factory untuk membuat 100 ulasan produk secara otomatis dengan menggunakan productt_id secara random
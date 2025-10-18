<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'collection_name' => 'Signature by Zodiac',
                'product_type' => 'Scented Candle 130gr',
                'variants' => '12 Zodiac',
                'price_2024' => 199000,
                'price_2025' => 219000,
                'net_price' => 142350,
                'notes' => 'Include pouch',
            ],
            [
                'collection_name' => 'Everyday Collection',
                'product_type' => 'Scented Candle 130gr',
                'variants' => 'Roasted Spice, Creamy Latte, Honey Milk Tea',
                'price_2024' => 199000,
                'price_2025' => 219000,
                'net_price' => 142350,
                'notes' => null,
            ],
            [
                'collection_name' => 'Timeless Collection',
                'product_type' => 'Scented Candle 130gr',
                'variants' => 'Faith, Hope, Love, Peace',
                'price_2024' => 199000,
                'price_2025' => 219000,
                'net_price' => 142350,
                'notes' => null,
            ],
            [
                'collection_name' => 'Wax Sachet',
                'product_type' => 'Wax Sachet',
                'variants' => 'Faith, Love, Hope, Peace',
                'price_2024' => null,
                'price_2025' => 69000,
                'net_price' => 44850,
                'notes' => 'New product',
            ],
            [
                'collection_name' => 'Reed Diffuser',
                'product_type' => 'Reed Diffuser 50ml',
                'variants' => 'Blossom Spring, Renjana, Arunika',
                'price_2024' => 189000,
                'price_2025' => 189000,
                'net_price' => 122850,
                'notes' => null,
            ],
            [
                'collection_name' => 'Massage Oil',
                'product_type' => 'Massage Oil 120ml',
                'variants' => 'After Work, Peaceful Night, Serenity',
                'price_2024' => 159000,
                'price_2025' => 189000,
                'net_price' => 122850,
                'notes' => 'Blend of Essential Oil, Coconut Oil, and Apricot Kernel Oil',
            ],
            [
                'collection_name' => 'Artisan EDP Signature Collection',
                'product_type' => 'Artisan EDP 30ml',
                'variants' => 'Lucé, Briélle, Angél, Écho, Xavé, Davé',
                'price_2024' => null,
                'price_2025' => 209000,
                'net_price' => 135850,
                'notes' => null,
            ],
        ]);
    }
}


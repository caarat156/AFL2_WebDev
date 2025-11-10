<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();

            // Relasi ke products, tapi boleh null
            $table->foreignId('product_id')
                    ->nullable() // review bisa dibuat tanpa terhubung dengan produk tertentu
                    ->constrained('products') // menghubungkan ke tabel products mengacu pada kolom id
                    ->onDelete('cascade'); // jika produk dihapus, review terkait juga dihapus
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->tinyInteger('rating'); // 1–5
            $table->text('comment');
            $table->timestamps();
        });
    }

    // public function down(): void
    // {
    //     Schema::dropIfExists('reviews');
    // }
};


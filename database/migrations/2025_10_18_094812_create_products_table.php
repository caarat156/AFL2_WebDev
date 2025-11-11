<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('products', function (Blueprint $table) { 
        $table->id(); 
        $table->string('collection_name'); 
        $table->string('product_type');
        $table->string('variants')->nullable(); 
        $table->integer('price_2024')->nullable();
        $table->integer('price_2025')->nullable();
        $table->integer('net_price')->nullable();
        $table->string('image')->nullable();
        $table->text('notes')->nullable();
        $table->timestamps(); 
    });
}

//up() = dipakai saat migrate (buat tabel)
// down() = dipakai saat rollback (hapus tabel)

};

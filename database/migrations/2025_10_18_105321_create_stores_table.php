<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location');
            $table->string('image')->nullable();
            $table->string('linkgmap');
            $table->timestamps();
        });
    }

    // public function down(): void
    // {
    //     Schema::dropIfExists('stores');
    // }

    // up() = dipakai saat migrate (buat tabel)
    // down() = dipakai saat rollback (hapus tabel)
    // php arrtisan migrate : rollback
};


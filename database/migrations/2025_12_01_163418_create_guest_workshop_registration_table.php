<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('guest_workshop_registration', function (Blueprint $table) {
        $table->id('guest_workshop_registration_id');

        $table->unsignedBigInteger('guest_id');
        $table->unsignedBigInteger('workshop_id');

        $table->date('registration_date');
        $table->string('payment_status');
        $table->string('payment_method');
        $table->decimal('payment_amount', 10, 2);
        $table->date('payment_date')->nullable();

        $table->timestamps();

        // Foreign Keys
        $table->foreign('guest_id')
                ->references('guest_id')->on('guest')
                ->onDelete('cascade');

            $table->foreign('workshop_id')
                ->references('workshop_id')->on('workshops')
                ->onDelete('cascade');
    });
}

public function down()
{
    Schema::dropIfExists('guest_workshop_registration');
}

};

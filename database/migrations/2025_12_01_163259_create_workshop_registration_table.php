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
        Schema::create('workshop_registration', function (Blueprint $table) {
            $table->id('workshop_registration_id');
    
            $table->unsignedBigInteger('workshop_id');
            $table->unsignedBigInteger('user_id');
    
            $table->date('registration_date');
            $table->string('payment_status');
            $table->string('payment_method');
            $table->decimal('payment_amount', 10, 2);
            $table->date('payment_date')->nullable();
    
            $table->timestamps();
    
            // Foreign Keys
            $table->foreign('workshop_id')
                    ->references('workshop_id')->on('workshops')
                    ->onDelete('cascade');
        
                $table->foreign('user_id')
                    ->references('id')->on('users')
                    ->onDelete('cascade');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('workshop_registration');
    }
};
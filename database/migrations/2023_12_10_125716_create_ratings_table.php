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
        Schema::create('ratings', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('place_id');
            $table->enum('star', [1, 2, 3, 4, 5]);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');   
            $table->foreign('place_id')->references('id')->on('places');
            $table->primary(['user_id', 'place_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};

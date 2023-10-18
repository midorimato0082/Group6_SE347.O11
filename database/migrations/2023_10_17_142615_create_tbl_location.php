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
        Schema::create('tbl_location', function (Blueprint $table) {
            $table->increments('id')->unsigned(false);
            $table->string('name', 40)->unique(); 
            $table->string('slug', 20)->unique(); 
            $table->integer('region_id');
            $table->boolean('status')->default('1');  
            $table->timestamps();

            $table->foreign('region_id')->references('id')->on('tbl_region');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_location');
    }
};

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
        Schema::create('tbl_region', function (Blueprint $table) {
            $table->increments('id')->unsigned(false);
            $table->string('name', 40)->unique(); 
            $table->string('slug', 20)->unique(); 
            $table->boolean('status')->default('1');  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_region');
    }
};

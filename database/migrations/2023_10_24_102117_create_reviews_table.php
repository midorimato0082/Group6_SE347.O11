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
        Schema::create('reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 100)->unique();
            $table->string('slug', 30)->unique(); 
            $table->text('desc')->nullable(); 
            $table->longText('content')->nullable(); 
            $table->string('tags', 255)->nullable(); 
            $table->integer('category_id');
            $table->integer('location_id');
            $table->integer('admin_id');
            $table->boolean('is_active')->default(true);
            $table->timestamps();  
            $table->integer('view_count')->default('0');
            
            $table->foreign('category_id')->references('id')->on('categories');    
            $table->foreign('location_id')->references('id')->on('locations');    
            $table->foreign('admin_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};

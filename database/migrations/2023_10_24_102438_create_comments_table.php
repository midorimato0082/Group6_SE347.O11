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
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id')->unsigned(false);
            $table->string('content', 255);
            $table->integer('user_id');
            $table->integer('review_id')->nullable();
            $table->integer('news_id')->nullable();
<<<<<<<< HEAD:database/migrations/2023_10_17_142737_create_comments_table.php
            $table->boolean('is_active')->default('1');
========
            $table->boolean('is_active')->default('1');  
>>>>>>>> feature/user-management:database/migrations/2023_10_24_102438_create_comments_table.php
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('review_id')->references('id')->on('reviews');
            $table->foreign('news_id')->references('id')->on('news');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};

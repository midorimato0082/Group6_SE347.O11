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
        Schema::create('tbl_comment', function (Blueprint $table) {
            $table->increments('id')->unsigned(false);
            $table->string('content', 255);  
            $table->integer('user_id');
            $table->integer('review_id')->nullable();
            $table->integer('news_id')->nullable();
            $table->boolean('status')->default('1');  
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('tbl_user');
            $table->foreign('review_id')->references('id')->on('tbl_review');
            $table->foreign('news_id')->references('id')->on('tbl_news');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_comment');
    }
};

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
        Schema::create('tbl_like_dislike', function (Blueprint $table) {
            $table->increments('id')->unsigned(false);
            $table->integer('user_id');
            $table->integer('review_id')->nullable();
            $table->integer('news_id')->nullable();
            $table->boolean('status');                      // like: 1; dislike: 0
            $table->timestamps();

//            $table->foreign('user_id')->references('id')->on('tbl_user');
//            $table->foreign('review_id')->references('id')->on('tbl_review');
//            $table->foreign('news_id')->references('id')->on('tbl_news');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_like_dislike');
    }
};

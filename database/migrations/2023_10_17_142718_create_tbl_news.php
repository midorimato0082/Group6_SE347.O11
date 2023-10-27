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
        Schema::create('tbl_news', function (Blueprint $table) {
            $table->increments('id')->unsigned(false);
            $table->string('title', 255);
            $table->text('slug')->nullable();
            $table->text('desc');
            $table->longText('content');
            $table->text('images')->nullable();
            $table->string('tags', 255)->nullable();
            $table->integer('admin_id');
            $table->boolean('status')->default('1');
            $table->timestamps();
            $table->integer('view_count')->default('0');
            $table->integer('like_count')->default('0');
            $table->integer('comment_count')->default('0');

//            $table->foreign('admin_id')->references('id')->on('tbl_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_news');
    }
};

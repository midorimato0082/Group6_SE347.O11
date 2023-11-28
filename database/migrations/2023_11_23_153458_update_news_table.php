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
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn('like_count');
            $table->dropColumn('dislike_count');
            $table->dropColumn('comment_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->after('view_count', function (Blueprint $table) {
                $table->integer('like_count')->default('0');
                $table->integer('dislike_count')->default('0');
                $table->integer('comment_count')->default('0');
            });
        });
    }
};

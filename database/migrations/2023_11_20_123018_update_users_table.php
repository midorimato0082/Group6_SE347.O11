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
        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('email_verified_at')->nullable()->change();
            $table->dropColumn('is_admin');
            $table->dropColumn('code');
            $table->dropColumn('code_created_at');
            $table->after('avatar', function (Blueprint $table) {
                $table->integer('role_id')->default('1');
                $table->boolean('is_active')->default(true);
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_admin')->default(true)->after('avatar');
            $table->dateTime('email_verified_at')->nullable()->change();
            $table->after('email_verified_at', function (Blueprint $table) {
                $table->string('code', 255)->nullable();
                $table->dateTime('code_created_at')->nullable();
            });
            $table->dropColumn(['role_id', 'is_active']);
        });
    }
};

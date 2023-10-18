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
        Schema::create('tbl_user', function (Blueprint $table) {
            $table->increments('id')->unsigned(false);
            $table->string('first_name', 20); 
            $table->string('last_name', 40); 
            $table->string('email', 30)->unique();    
            $table->string('phone', 10)->unique()->nullable();  
            $table->string('password', 255);
            $table->string('avatar', 255)->nullable();  
            $table->string('code', 255)->nullable();
            $table->dateTime('email_verified_at')->nullable();            
            $table->boolean('is_admin')->default('0');             
            $table->timestamps();              
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_user');
    }
};
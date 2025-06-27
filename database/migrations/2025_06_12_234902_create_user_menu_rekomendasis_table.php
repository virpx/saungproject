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
        Schema::create('user_menu_rekomendasis', function (Blueprint $table) {
           $table->id();
        $table->unsignedBigInteger('user_id');
        $table->unsignedBigInteger('menu_id');
        $table->integer('rating')->nullable(); 
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_menu_rekomendasis');
    }
};

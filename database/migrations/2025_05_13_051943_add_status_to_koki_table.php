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
        Schema::table('kokis', function (Blueprint $table) {
            $table->enum('status', ['pending','approved', 'active', 'rejected'])->default('pending'); // Menambahkan kolom status
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kokis', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};

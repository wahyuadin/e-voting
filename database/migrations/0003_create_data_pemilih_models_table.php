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
        Schema::create('data_pemilih_models', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('kandidat_id')->references('id')->on('kandidat_models')->onDelete('cascade')->unique();
            $table->foreignUuid('user_id')->references('id')->on('users')->onDelete('cascade')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_pemilih_models');
    }
};

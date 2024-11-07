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
        Schema::create('kandidat_models', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama');
            $table->string('foto')->nullable()->default('default.jpg');
            $table->string('visi');
            $table->string('misi');
            $table->string('no_urut');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kandidat_models');
    }
};

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
        Schema::dropIfExists('borga_shades');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('borga_shades', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('capacity');
            $table->string('location');
            $table->string('map')->nullable();
            $table->enum('status',[ 'active', 'closed', 'maintenance'])->default('active');
            $table->timestamps();
        });
    }
};

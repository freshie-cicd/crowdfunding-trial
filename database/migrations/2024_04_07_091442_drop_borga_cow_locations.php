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
        Schema::dropIfExists('borga_cow_locations');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('borga_cow_locations', function (Blueprint $table) {
            $table->id();
            $table->string('cow_id');
            $table->string('shade_id');
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }
};

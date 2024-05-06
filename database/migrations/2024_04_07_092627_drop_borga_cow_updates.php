<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('borga_cow_updates');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('borga_cow_updates', function (Blueprint $table) {
            $table->id();
            $table->string('weight')->nullable();
            $table->string('heat')->nullable();
            $table->boolean('doctors_visit')->default(0);
            $table->boolean('vaccine')->default(0);
            $table->boolean('is_sick')->default(0);
            $table->string('note')->nullable();
            $table->boolean('is_sold')->default(0);
            $table->timestamps();
        });
    }
};

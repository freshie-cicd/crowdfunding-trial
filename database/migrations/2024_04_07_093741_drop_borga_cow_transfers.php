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
        Schema::dropIfExists('borga_transfers');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('borga_transfers', function (Blueprint $table) {
            $table->id();
            $table->string('cow_id');
            $table->string('from');
            $table->string('to');
            $table->string('supervisor');
            $table->enum('status',[ 'active', 'closed', 'maintenance'])->default('active');
            $table->timestamps();
        });
    }
};

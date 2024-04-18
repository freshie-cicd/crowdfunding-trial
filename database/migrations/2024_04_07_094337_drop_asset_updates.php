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
        Schema::dropIfExists('asset_updates');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('asset_updates', function (Blueprint $table) {
            $table->id();
            $table->string('asset_id');
            $table->string('weight');
            $table->string('temparature');
            $table->string('height');
            $table->string('length');
            $table->enum('health_status',[ 'normal', 'sick', 'pregnent', 'adnormal'])->default('normal');
            $table->boolean('doctor_visited')->default(0);
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }
};
